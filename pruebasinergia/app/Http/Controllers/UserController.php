<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ], [
            'name.required' => 'El campo Nombre es obligatorio.',
            'email.required' => 'El campo Correo Electrónico es obligatorio.',
            'email.email' => 'Ingrese una dirección de correo electrónico válida.',
            'email.unique' => 'Este correo electrónico ya está registrado. Utilice otro.',
            'password.required' => 'El campo Contraseña es obligatorio.',
        ]);
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        
        $user->save();
    
        return redirect()->route('welcome')->with('success', 'Usuario creado exitosamente.');
    }

    public function changestatus($id)
{
    $user = User::find($id);
    
    $user->status = ($user->status === 1) ? 0 : 1;
    $user->save();

    return response()->json(['success' => 'Estado cambiado exitosamente']);
}


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['success' => 'Usuario eliminado exitosamente']);
    }
}
