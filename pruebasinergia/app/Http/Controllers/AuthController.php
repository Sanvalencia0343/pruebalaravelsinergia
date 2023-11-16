<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo Correo Electrónico es obligatorio.',
            'email.email' => 'Ingrese una dirección de correo electrónico válida.',
            'password.required' => 'El campo Contraseña es obligatorio.',
        ]);

        if (Auth::attempt($credentials)) {
        // Obtener el usuario autenticado
        $user = Auth::user();

        if ($user->status != 1) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta está inactiva. Por favor, ponte en contacto con el administrador.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('index');
    }


        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
