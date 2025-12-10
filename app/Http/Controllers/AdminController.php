<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.dashboard'); 
    }
    
    public function userIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users')); 
    }

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin' && $user->id === Auth::id()) {
             return back()->with('error', 'No puedes desactivar tu propia cuenta de Administrador.');
        }

        $newStatus = ($user->status == 'activo') ? 'inactivo' : 'activo';
        $user->status = $newStatus;
        $user->save();

        return back()->with('success', "El usuario **{$user->name}** ha sido puesto en estado **'{$newStatus}'**.");
    }


    public function createAdminForm()
    {
        return view('admin.users.create_admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'cedula' => 'required|string|unique:users,cedula',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'cedula' => $request->cedula,
            'birthdate' => $request->birthdate,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', 
            'status' => 'activo', 
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Nuevo Administrador creado exitosamente.');
    }

    public function runReminderScript(Request $request)
    {
        $request->validate(['minutes' => 'required|integer|min:1']);
        $minutes = $request->minutes;

        Artisan::call('recordatorioReservas', ['minutes' => $minutes]);

        $output = Artisan::output();

        return back()->with('success', "Script ejecutado exitosamente, se encontraron reservas con mas de {$minutes} minutos de creada. **Mensaje del sistema:** " . trim($output));
    }
}