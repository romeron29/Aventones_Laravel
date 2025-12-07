<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function showRegister() {
        return view('auth.register');
    }

    // Guardar usuario nuevo
    public function register(Request $request) {
        
        // 1. Validaciones COMPLETAS
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'cedula' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:chofer,pasajero',
            'birthdate' => 'required|date',
            'phone' => 'required',
        ]);

        // 2. Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'cedula' => $request->cedula,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => 'pendiente', 
            'password' => Hash::make($request->password),
        ]);

        // 3. ENVIAR EL CORREO 
        Mail::to($user->email)->send(new ActivationMail($user));

        return redirect()->route('login')
            ->with('success', 'Cuenta creada. Hemos enviado un correo para activar tu cuenta.');
    }

    // Mostrar Login
    public function showLogin() {
        return view('auth.login');
    }

    // Procesar Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->status != 'activo') {
                Auth::logout();
                return back()->withErrors(['email' => 'Tu cuenta aún está pendiente de activación.']);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Método para activar cuenta desde el correo
    public function activateAccount($userId) {
        $user = User::find($userId);

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'Usuario no encontrado.']);
        }

        $user->status = 'activo';
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '¡Cuenta activada correctamente! Bienvenido.');
    }
}