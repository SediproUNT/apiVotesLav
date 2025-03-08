<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Evento;
use App\Models\Carrera;
use App\Models\Sediprano;
use App\Models\Asistencia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Enums\EstadoEvento;
use App\Enums\Genero;

class PublicPanelController extends Controller
{
    public function index()
    {
        $totalSedipranos = Sediprano::count();
        $totalEventos = Evento::count();
        $totalAsistencias = Asistencia::count();
        $asistenciasPorArea = DB::table('asistencias')
            ->join('sedipranos', 'asistencias.sediprano_id', '=', 'sedipranos.id')
            ->join('areas', 'sedipranos.area_id', '=', 'areas.id')
            ->select('areas.nombre', DB::raw('count(*) as total'))
            ->groupBy('areas.nombre')
            ->get();
        $proximosEventos = Evento::where('fecha', '>=', now()->format('Y-m-d'))
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->take(3)
            ->get();
        return view('public.dashboard', compact(
            'totalSedipranos',
            'totalEventos',
            'totalAsistencias',
            'asistenciasPorArea',
            'proximosEventos'
        ));
    }

    public function sedipranos()
    {
        $sedipranos = Sediprano::with(['user', 'carrera', 'cargo', 'area'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $areas = Area::all();
        return view('public.sedipranos', compact('sedipranos', 'areas'));
    }

    public function asistencias()
    {
        $eventos = Evento::orderBy('fecha', 'desc')->get();
        $asistencias = Asistencia::with(['sediprano.user', 'evento'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // Si es una solicitud AJAX, devolver solo los datos
        if (request()->ajax()) {
            return response()->json([
                'asistencias' => $asistencias
            ]);
        }
        return view('public.asistencias', compact('asistencias', 'eventos'));
    }

    public function asistenciasPorEvento($eventoId)
    {
        $evento = Evento::findOrFail($eventoId);
        $asistencias = Asistencia::with(['sediprano.user', 'sediprano.area'])
            ->where('evento_id', $eventoId)
            ->orderBy('hora_registro')
            ->get();
        return view('public.asistencias-evento', compact('asistencias', 'evento'));
    }

    public function eventos()
    {
        $eventos = Evento::orderBy('fecha', 'desc')
            ->paginate(10) // Cambiar get() por paginate() y especificar número de items por página
            ->through(function ($evento) {
                // Actualizar el estado basado en la fecha/hora
                $ahora = now();
                $fechaHoraInicio = Carbon::parse($evento->fecha . ' ' . $evento->hora_inicio);
                $fechaHoraFin = Carbon::parse($evento->fecha . ' ' . $evento->hora_fin);
                if ($evento->estado === EstadoEvento::Programado->value) {
                    if ($ahora->between($fechaHoraInicio, $fechaHoraFin)) {
                        $evento->update(['estado' => EstadoEvento::EnCurso->value]);
                    }
                } elseif ($evento->estado === EstadoEvento::EnCurso->value) {
                    if ($ahora->isAfter($fechaHoraFin)) {
                        $evento->update(['estado' => EstadoEvento::Finalizado->value]);
                    }
                }
                return $evento;
            });
        return view('public.eventos', compact('eventos'));
    }

    public function perfilSediprano($id)
    {
        $sediprano = Sediprano::with(['user', 'carrera', 'cargo', 'area', 'asistencias.evento'])
            ->findOrFail($id);
        return view('public.perfil-sediprano', compact('sediprano'));
    }

    // CRUD DE SEDIPRANO
    public function createSediprano()
    {
        $areas = Area::all();
        $cargos = Cargo::all();
        $carreras = Carrera::all();
        return view('public.sedipranos-create', compact('areas', 'cargos', 'carreras'));
    }

    public function storeSediprano(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'required|string|unique:sedipranos,codigo',
                'nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:100',
                'segundo_apellido' => 'required|string|max:100', // Cambiado a required
                'dni' => 'required|string|size:8|unique:sedipranos,dni',
                'email' => 'required|email|unique:users,email',
                'carrera_id' => 'required|exists:carreras,id',
                'area_id' => 'required|exists:areas,id',
                'cargo_id' => 'required|exists:cargos,id',
                'genero' => 'required|string|in:' . implode(',', array_column(Genero::cases(), 'value')),
                'celular' => 'nullable|string|size:9',
                'fecha_nacimiento' => 'nullable|date'
            ]);

            DB::beginTransaction();

            // Crear usuario primero
            $user = User::create([
                'name' => $request->nombre . ' ' . $request->primer_apellido . ($request->segundo_apellido ? ' ' . $request->segundo_apellido : ''),
                'email' => $request->email,
                'password' => Hash::make($request->codigo)
            ]);

            // Formatear fecha_nacimiento
            $fechaNacimiento = $request->fecha_nacimiento ? date('Y-m-d', strtotime($request->fecha_nacimiento)) : null;

            // Crear sediprano con todos los campos requeridos
            $sediprano = Sediprano::create([
                'codigo' => $request->codigo,
                'dni' => $request->dni,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'carrera_id' => $request->carrera_id,
                'area_id' => $request->area_id,
                'cargo_id' => $request->cargo_id,
                'genero' => $request->genero,
                'celular' => $request->celular,
                'fecha_nacimiento' => $fechaNacimiento,
                'user_id' => $user->id,
                'secret_key' => Str::random(32),
                'token' => Str::random(16)
            ]);

            DB::commit();
            return redirect()->route('public.sedipranos')->with('success', 'Miembro creado con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating sediprano: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el miembro: ' . $e->getMessage());
        }
    }

    public function editSediprano($id)
    {
        $sediprano = Sediprano::with('user')->findOrFail($id);
        $areas = Area::all();
        $cargos = Cargo::all();
        $carreras = Carrera::all();
        return view('public.sedipranos-edit', compact('sediprano', 'areas', 'cargos', 'carreras'));
    }

    public function updateSediprano(Request $request, $id)
    {
        try {
            $sediprano = Sediprano::findOrFail($id);

            $request->validate([
                'codigo' => 'required|string|unique:sedipranos,codigo,' . $sediprano->id,
                'nombre' => 'required|string|max:255',
                'primer_apellido' => 'required|string|max:100',
                'segundo_apellido' => 'nullable|string|max:100',
                'dni' => 'required|string|size:8|unique:sedipranos,dni,' . $sediprano->id,
                'email' => 'required|email|unique:users,email,' . $sediprano->user_id,
                'carrera_id' => 'required|exists:carreras,id',
                'area_id' => 'required|exists:areas,id',
                'cargo_id' => 'required|exists:cargos,id',
                'fecha_nacimiento' => 'nullable|date'
            ]);

            DB::beginTransaction();

            // Actualizar usuario
            $sediprano->user->update([
                'name' => $request->nombre . ' ' . $request->primer_apellido . ($request->segundo_apellido ? ' ' . $request->segundo_apellido : ''),
                'email' => $request->email
            ]);

            // Formatear fecha_nacimiento
            $fechaNacimiento = $request->fecha_nacimiento ? date('Y-m-d', strtotime($request->fecha_nacimiento)) : null;

            // Actualizar sediprano
            $sediprano->update([
                'codigo' => $request->codigo,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'dni' => $request->dni,
                'carrera_id' => $request->carrera_id,
                'area_id' => $request->area_id,
                'cargo_id' => $request->cargo_id,
                'fecha_nacimiento' => $fechaNacimiento
            ]);

            DB::commit();
            return redirect()->route('public.sedipranos')->with('success', 'Miembro actualizado con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar el miembro: ' . $e->getMessage());
        }
    }

    public function destroySediprano($id)
    {
        try {
            $sediprano = Sediprano::findOrFail($id);
            // Eliminar usuario asociado y el sediprano (con on delete cascade)
            $sediprano->user->delete();
            return redirect()->route('public.sedipranos')->with('success', 'Miembro eliminado con éxito');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el miembro: ' . $e->getMessage());
        }
    }

    // CRUD DE EVENTOS
    public function createEvento()
    {
        return view('public.eventos-create');
    }

    public function storeEvento(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'lugar' => 'nullable|string|max:255',
                'estado' => 'required|in:pendiente,en_curso,finalizado'
            ]);

            Evento::create($request->all());
            return redirect()->route('public.eventos')->with('success', 'Evento creado con éxito');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al crear el evento: ' . $e->getMessage());
        }
    }

    public function editEvento($id)
    {
        $evento = Evento::findOrFail($id);
        return view('public.eventos-edit', compact('evento'));
    }

    public function updateEvento(Request $request, $id)
    {
        try {
            $evento = Evento::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'fecha' => 'required|date',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'lugar' => 'nullable|string|max:255',
                'estado' => 'required|in:pendiente,en_curso,finalizado'
            ]);

            $evento->update($request->all());
            return redirect()->route('public.eventos')->with('success', 'Evento actualizado con éxito');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar el evento: ' . $e->getMessage());
        }
    }

    public function destroyEvento($id)
    {
        try {
            Evento::findOrFail($id)->delete();
            return redirect()->route('public.eventos')->with('success', 'Evento eliminado con éxito');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el evento: ' . $e->getMessage());
        }
    }

    // TOMA DE ASISTENCIAS
    public function tomarAsistencia($eventoId)
    {
        $evento = Evento::findOrFail($eventoId);
        $sedipranos = Sediprano::with(['user', 'area'])->orderBy('codigo')->get();
        // Obtener las asistencias ya registradas para este evento
        $asistenciasRegistradas = Asistencia::where('evento_id', $eventoId)
            ->get()
            ->keyBy('sediprano_id')
            ->toArray();
        return view('public.tomar-asistencia', compact('evento', 'sedipranos', 'asistenciasRegistradas'));
    }

    public function registrarAsistencia(Request $request, $eventoId)
    {
        try {
            $request->validate([
                'asistencias' => 'required|array',
                'asistencias.*.sediprano_id' => 'required|exists:sedipranos,id',
                'asistencias.*.estado' => 'required|in:presente,tardanza,falta',
                'asistencias.*.observacion' => 'nullable|string'
            ]);
            DB::beginTransaction();
            $evento = Evento::findOrFail($eventoId);
            $ahora = now();
            Asistencia::where('evento_id', $eventoId)->delete();

            // Registrar las nuevas asistencias
            foreach ($request->asistencias as $asistencia) {
                Asistencia::create([
                    'evento_id' => $eventoId,
                    'sediprano_id' => $asistencia['sediprano_id'],
                    'hora_registro' => $ahora,
                    'estado' => $asistencia['estado'],
                    'observacion' => $asistencia['observacion'] ?? null
                ]);
            }
            DB::commit();

            return redirect()->route('public.asistencias.evento', $eventoId)
                ->with('success', 'Asistencias registradas con éxito');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar asistencias: ' . $e->getMessage());
        }
    }

    public function registrarAsistenciaIndividual(Request $request, $eventoId)
    {
        try {
            $request->validate([
                'sediprano_id' => 'required|exists:sedipranos,id',
                'estado' => 'required|in:presente,tardanza,falta',
                'observacion' => 'nullable|string'
            ]);

            $evento = Evento::findOrFail($eventoId);
            $sediprano = Sediprano::with('user')->findOrFail($request->sediprano_id);
            $ahora = now();

            // Verificar si ya existe una asistencia para este evento/sediprano
            $asistenciaExistente = Asistencia::where('evento_id', $eventoId)
                ->where('sediprano_id', $request->sediprano_id)
                ->first();

            if ($asistenciaExistente) {
                // Actualizar la asistencia existente
                $asistenciaExistente->update([
                    'estado' => $request->estado,
                    'observacion' => $request->observacion,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Asistencia actualizada con éxito',
                    'asistencia' => $asistenciaExistente,
                    'nombre' => $sediprano->user->name,
                    'codigo' => $sediprano->codigo
                ]);
            }

            // Crear nueva asistencia
            $asistencia = Asistencia::create([
                'evento_id' => $eventoId,
                'sediprano_id' => $request->sediprano_id,
                'hora_registro' => $ahora,
                'estado' => $request->estado,
                'observacion' => $request->observacion ?? 'Registro manual individual'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Asistencia registrada con éxito',
                'asistencia' => $asistencia,
                'nombre' => $sediprano->user->name,
                'codigo' => $sediprano->codigo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para registrar asistencias manualmente de forma individual - MANTENER ESTA VERSIÓN
    public function registrarManual(Request $request)
    {
        try {
            $request->validate([
                'evento_id' => 'required|exists:eventos,id',
                'codigo_dni' => 'required|string',
                'estado' => 'required|in:presente,tardanza,falta',
                'observacion' => 'nullable|string'
            ]);

            // Buscar sediprano por código o DNI
            $sediprano = Sediprano::where('codigo', $request->codigo_dni)
                ->orWhere('dni', $request->codigo_dni)
                ->with('user')
                ->first();

            if (!$sediprano) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró ningún miembro con ese código o DNI'
                ], 404);
            }

            // Verificar si ya existe una asistencia para este evento/sediprano
            $asistenciaExistente = Asistencia::where('evento_id', $request->evento_id)
                ->where('sediprano_id', $sediprano->id)
                ->first();

            if ($asistenciaExistente) {
                $asistenciaExistente->update([
                    'estado' => $request->estado,
                    'observacion' => $request->observacion ?? 'Registro manual actualizado'
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Asistencia actualizada con éxito para ' . $sediprano->user->name,
                    'nombre' => $sediprano->user->name,
                    'codigo' => $sediprano->codigo
                ]);
            }

            // Crear nueva asistencia
            $asistencia = Asistencia::create([
                'evento_id' => $request->evento_id,
                'sediprano_id' => $sediprano->id,
                'hora_registro' => now(),
                'estado' => $request->estado,
                'observacion' => $request->observacion ?? 'Registro manual individual'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Asistencia registrada con éxito para ' . $sediprano->user->name,
                'nombre' => $sediprano->user->name,
                'codigo' => $sediprano->codigo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function escanearQR()
    {
        $eventos = Evento::where('estado', 'en_curso')
            ->orWhere(function ($query) {
                $fecha = now()->format('Y-m-d');
                $hora = now()->format('H:i:s');
                $query->where('fecha', $fecha)
                    ->where('hora_inicio', '<=', $hora)
                    ->where('hora_fin', '>', $hora);
            })
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();
        return view('public.escanear-qr', compact('eventos'));
    }

    public function procesarQR(Request $request)
    {
        $request->validate([
            'qr_data' => 'required',
            'evento_id' => 'required|exists:eventos,id'
        ]);

        try {
            // Obtenemos los datos del QR, pueden venir como string o ya como array
            $qrData = is_array($request->qr_data) ? $request->qr_data : json_decode($request->qr_data, true);

            if (!$qrData || !isset($qrData['id']) || !isset($qrData['token']) || !isset($qrData['timestamp']) || !isset($qrData['signature'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR inválido: datos incompletos'
                ], 400);
            }

            // Obtener el sediprano
            $sediprano = Sediprano::with(['user', 'carrera'])->findOrFail($qrData['id']);

            // Recrear los datos base para verificar firma
            $qrBaseData = array_diff_key($qrData, ['signature' => '']);
            $expectedHmac = hash_hmac('sha256', json_encode($qrBaseData), $sediprano->secret_key);

            // Verificar HMAC
            if (!hash_equals($expectedHmac, $qrData['signature'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR inválido: firma no coincide'
                ], 400);
            }

            // Verificar token
            if ($sediprano->token !== $qrData['token']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR inválido: token no coincide'
                ], 400);
            }

            // Verificar si ya existe una asistencia para este evento/sediprano
            $asistenciaExistente = Asistencia::where('evento_id', $request->evento_id)
                ->where('sediprano_id', $sediprano->id)
                ->first();

            if ($asistenciaExistente) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Este miembro ya registró su asistencia para este evento',
                    'nombre' => $sediprano->user->name
                ], 200);
            }

            // Registrar asistencia
            $evento = Evento::findOrFail($request->evento_id);
            $ahora = now();
            $horaInicio = Carbon::parse($evento->fecha . ' ' . $evento->hora_inicio);
            $tolerancia = 15; // minutos de tolerancia
            $estado = $ahora->diffInMinutes($horaInicio) <= $tolerancia ? 'presente' : 'tardanza';

            $asistencia = Asistencia::create([
                'evento_id' => $request->evento_id,
                'sediprano_id' => $sediprano->id,
                'hora_registro' => $ahora,
                'estado' => $estado,
                'observacion' => 'Registro por escaneo QR'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Asistencia registrada con éxito',
                'nombre' => $sediprano->user->name,
                'codigo' => $sediprano->codigo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar QR: ' . $e->getMessage()
            ], 500);
        }
    }
}
