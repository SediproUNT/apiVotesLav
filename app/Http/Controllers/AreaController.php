<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AreaController extends Controller
{
    public function index(): JsonResponse
    {
        $areas = Area::all();
        return response()->json(['areas' => $areas], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|unique:areas|max:255',
            'abreviatura' => 'required|unique:areas|max:10'
        ]);

        $area = Area::create($validated);
        return response()->json(['area' => $area], 201);
    }

    public function show(Area $area): JsonResponse
    {
        return response()->json(['area' => $area], 200);
    }

    public function update(Request $request, Area $area): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', Rule::unique('areas')->ignore($area->id), 'max:255'],
            'abreviatura' => ['required', Rule::unique('areas')->ignore($area->id), 'max:10']
        ]);

        $area->update($validated);
        return response()->json(['area' => $area], 200);
    }

    public function destroy(Area $area): JsonResponse
    {
        $area->delete();
        return response()->json(null, 204);
    }
}
