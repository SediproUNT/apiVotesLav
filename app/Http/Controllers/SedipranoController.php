<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sediprano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class SedipranoController extends Controller
{
    public function index()
    {
        $sedipranos = Sediprano::with(['user', 'carrera', 'cargo', 'area'])->get();
        return response()->json($sedipranos);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'codigo' => 'required|numeric|unique:sedipranos',
                'dni' => 'nullable|string|size:8',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'required|string|max:255',
                'carrera_id' => 'required|exists:carreras,id',
                'cargo_id' => 'required|exists:cargos,id',
                'area_id' => 'nullable|exists:areas,id',
                'genero' => 'required|string',
                'celular' => 'nullable|string|size:9',
                'fecha_nacimiento' => 'nullable|date_format:d/m/Y',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Convertir el formato de fecha
            $fechaNacimiento = $request->fecha_nacimiento ?
                \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->format('Y-m-d') :
                null;

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->codigo)
            ]);

            // Crear sediprano con los campos actualizados
            $sediprano = Sediprano::create([
                'codigo' => $request->codigo,
                'dni' => $request->dni,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'carrera_id' => $request->carrera_id,
                'genero' => $request->genero,
                'cargo_id' => $request->cargo_id,
                'area_id' => $request->area_id,
                'celular' => $request->celular,
                'fecha_nacimiento' => $fechaNacimiento,
                'user_id' => $user->id
            ]);

            // Cargar las relaciones
            $sediprano->load(['user', 'carrera', 'cargo', 'area']);

            return response()->json([
                'status' => 'success',
                'message' => 'Sediprano creado exitosamente. La contraseña es el código: ' . $request->codigo,
                'data' => [
                    'sediprano' => $sediprano,
                    'user' => $user
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el sediprano',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $sediprano = Sediprano::with(['user', 'carrera', 'cargo', 'area'])->find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }
        return response()->json($sediprano);
    }

    public function update(Request $request, $id)
    {
        $sediprano = Sediprano::find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'codigo' => 'numeric|unique:sedipranos,codigo,' . $id,
            'dni' => 'nullable|string|size:8',
            'primer_apellido' => 'string|max:255',
            'segundo_apellido' => 'string|max:255',
            'carrera_id' => 'exists:carreras,id',
            'cargo_id' => 'exists:cargos,id',
            'area_id' => 'nullable|exists:areas,id',
            'genero' => 'string',
            'celular' => 'nullable|string|size:9',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $sediprano->update($request->all());
        $sediprano->load(['user', 'carrera', 'cargo', 'area']);
        return response()->json([
            'message' => 'Sediprano actualizado exitosamente',
            'data' => $sediprano
        ]);
    }

    public function destroy($id)
    {
        $sediprano = Sediprano::find($id);
        if (!$sediprano) {
            return response()->json([
                'message' => 'Sediprano no encontrado'
            ], 404);
        }

        $sediprano->delete();
        return response()->json([
            'message' => 'Sediprano eliminado exitosamente'
        ]);
    }

    public function generateQrCode($id)
    {
        $sediprano = Sediprano::with(['user', 'carrera'])->findOrFail($id);

        try {
            // Verificar si ya tiene un QR generado
            if ($sediprano->qr_code && $sediprano->qr_path) {
                // Generar la URL usando asset()
                $qrUrl = asset('storage/' . $sediprano->qr_path);

                return response()->json([
                    'message' => 'Este Sediprano ya tiene un código QR generado',
                    'data' => [
                        'qr_code' => $sediprano->qr_code,
                        'qr_url' => $qrUrl
                    ]
                ]);
            }

            // Generar secret key único si no existe
            if (!$sediprano->secret_key) {
                $sediprano->secret_key = bin2hex(random_bytes(32));
            }

            // Generar token UUID v4
            $token = (string) Str::uuid();
            $sediprano->token = $token;

            // Crear datos base para el QR
            $qrBaseData = [
                'id' => $sediprano->id,
                'token' => $token,
                'codigo' => $sediprano->codigo,
                'dni_hash' => hash('sha256', $sediprano->dni),
                'timestamp' => time()
            ];

            // Generar HMAC de los datos
            $hmac = hash_hmac('sha256', json_encode($qrBaseData), $sediprano->secret_key);
            $sediprano->qr_hash = $hmac;

            // Datos completos del QR incluyendo HMAC
            $qrData = array_merge($qrBaseData, ['signature' => $hmac]);

            // Generar código personalizado para el nombre del archivo
            $codigoPersonalizado = sprintf(
                "SED-%s-%s-%s",
                $sediprano->codigo,
                substr($token, 0, 8),
                substr($hmac, 0, 8)
            );

            // Configuración personalizable del QR
            $config = [
                'size' => 300,              // Tamaño del QR
                'margin' => 2,              // Margen del QR
                'color' => '#000000',       // Color del QR (negro por defecto)
                'background' => '#ffffff'    // Color de fondo (blanco por defecto)
            ];

            // Configurar el generador de QR
            $renderer = new ImageRenderer(
                new RendererStyle(
                    $config['size'],    // Tamaño
                    $config['margin']   // Margen
                ),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);

            // Generar QR
            $qrSvg = $writer->writeString(json_encode($qrData));

            // Agregar estilos SVG personalizados
            $qrSvg = str_replace(
                '<svg ',
                sprintf('<svg style="background-color: %s;" ', $config['background']),
                $qrSvg
            );

            // Modificar el color del QR
            $qrSvg = str_replace(
                'fill="#000000"',
                sprintf('fill="%s"', $config['color']),
                $qrSvg
            );

            // Crear la ruta donde se guardará el QR
            $qrPath = 'qrcodes/' . $codigoPersonalizado . '.svg';

            // Guardar el QR en el storage
            Storage::disk('public')->put($qrPath, $qrSvg);

            // Actualizar el sediprano
            $sediprano->update([
                'qr_code' => $codigoPersonalizado,
                'qr_path' => $qrPath
            ]);

            // Generar la URL usando asset()
            $qrUrl = asset('storage/' . $qrPath);

            return response()->json([
                'message' => 'Código QR generado exitosamente',
                'data' => [
                    'qr_code' => $codigoPersonalizado,
                    'qr_url' => $qrUrl
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al generar el código QR',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para validar un QR
    public function validateQr(Request $request)
    {
        try {
            // Verificar si qr_data ya es un array o necesita ser decodificado
            $qrData = $request->qr_data;
            if (is_string($qrData)) {
                $qrData = json_decode($qrData, true);
            }

            $eventoId = $request->evento_id; // ID del evento para la asistencia

            // Verificar que existan todos los campos necesarios
            if (!isset($qrData['id'], $qrData['token'], $qrData['signature'])) {
                throw new \Exception('QR inválido: datos incompletos');
            }

            // Obtener el sediprano con sus relaciones
            $sediprano = Sediprano::with(['user', 'carrera'])->findOrFail($qrData['id']);

            // Recrear los datos base
            $qrBaseData = array_diff_key($qrData, ['signature' => '']);

            // Verificar HMAC
            $expectedHmac = hash_hmac('sha256', json_encode($qrBaseData), $sediprano->secret_key);
            if (!hash_equals($expectedHmac, $qrData['signature'])) {
                throw new \Exception('QR inválido: firma no coincide');
            }

            // Verificar token
            if ($sediprano->token !== $qrData['token']) {
                throw new \Exception('QR inválido: token no coincide');
            }

            // Registrar asistencia si se proporcionó un evento_id
            if ($eventoId) {
                // Usar los campos correctos según la estructura de la tabla
                $asistencia = $sediprano->asistencias()->create([
                    'evento_id' => $eventoId,
                    'hora_registro' => now(),
                    'estado' => 'presente',
                    'observacion' => $request->observacion ?? 'Registro por escaneo QR'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'QR válido',
                'data' => [
                    'sediprano' => [
                        'id' => $sediprano->id,
                        'codigo' => $sediprano->codigo,
                        'nombre' => $sediprano->user->name,
                        'carrera' => $sediprano->carrera ? $sediprano->carrera->nombre : null
                    ],
                    'asistencia' => isset($asistencia) ? [
                        'id' => $asistencia->id,
                        'hora_registro' => $asistencia->hora_registro->format('H:i:s'),
                        'estado' => $asistencia->estado
                    ] : null,
                    'timestamp' => $qrData['timestamp']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getSedipranosWithRelations()
    {
        try {
            $sedipranos = Sediprano::with(['area', 'cargo', 'user', 'carrera'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $sedipranos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los sedipranos: ' . $e->getMessage()
            ], 500);
        }
    }
}
