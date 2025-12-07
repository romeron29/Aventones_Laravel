<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    // Mostrar mis vehículos
    public function index()
    {
        // Obtiene solo los vehículos del usuario conectado
        $vehicles = Auth::user()->vehicles;
        return view('vehicles.index', compact('vehicles'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('vehicles.create');
    }

    // Guardar en la BD
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|unique:vehicles',
            'marca' => 'required',
            'modelo' => 'required',
            'year' => 'required|numeric',
            'color' => 'required',
            'capacity' => 'required|numeric|min:1',
            'photo' => 'nullable|image|max:2048'
        ]);

        // 2. Subir Foto 
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('vehicles', 'public');
        }

        // 3. Crear vehículo
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->vehicles()->create([
            'placa' => $request->placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'year' => $request->year,
            'color' => $request->color,
            'capacity' => $request->capacity,
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehículo registrado correctamente.');
    }


    // Elimina un vehiculo con su validación 
    public function destroy(Vehicle $vehicle)
    {

        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }

        if ($vehicle->rides()->exists()) {
            return back()->with('error', 'No puedes eliminar este vehículo porque tiene viajes asociados en el historial.');
        }

        $vehicle->delete();
        return back()->with('success', 'Vehículo eliminado correctamente.');
    }
}
