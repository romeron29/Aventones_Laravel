<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    // Listar viajes disponibles (Mercado de Rides)
    public function index()
    {
        $rides = Ride::where('departure_time', '>=', now())
            ->orderBy('departure_time', 'asc')
            ->get();
        return view('rides.index', compact('rides'));
    }

    // Formulario para publicar viaje
    public function create()
    {
        if (Auth::user()->role !== 'chofer') {
            return redirect()->route('dashboard')->with('error', 'Solo los choferes pueden publicar viajes.');
        }

        $vehicles = Auth::user()->vehicles;

        if ($vehicles->isEmpty()) {
            return redirect()->route('vehicles.create')->with('error', 'Primero debes registrar un vehículo.');
        }

        return view('rides.create', compact('vehicles'));
    }

    // Guardar el viaje
    // Guardar el viaje
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'cost' => 'required|numeric|min:0',
            'seats_available' => 'required|integer|min:1',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Guardamos el usuario y le decimos al editor que es TU modelo User

        // Verificamos que el vehículo pertenezca al usuario usando la variable $user
        $vehicle = $user->vehicles()->find($request->vehicle_id);

        if (!$vehicle) {
            return back()->withErrors(['vehicle_id' => 'El vehículo seleccionado no es válido o no te pertenece.']);
        }

        Ride::create([
            'user_id' => $user->id,
            'vehicle_id' => $request->vehicle_id,
            'name' => 'Viaje a ' . $request->destination,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_time' => $request->departure_time,
            'cost' => $request->cost,
            'seats_available' => $request->seats_available,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Viaje publicado exitosamente!');
    }


    // Ver mis viajes publicados (Chofer)
    public function myRides()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        $rides = $user->rides()->with('vehicle')->orderBy('departure_time', 'desc')->get();

        return view('rides.index', compact('rides'));
    }
    // Cancelar/Eliminar Viaje
    public function destroy(Ride $ride)
    {

        if (Auth::id() !== $ride->user_id) {
            abort(403);
        }
        $ride->delete();

        return back()->with('success', 'El viaje ha sido cancelado y eliminado.');
    }
}
