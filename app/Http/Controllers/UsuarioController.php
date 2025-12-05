<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\UsuarioInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo mostrar usuarios regulares, excluir administradores
        $usuarios = Usuario::with('usuarioInfo')
            ->where('rol', 'Usuario')
            ->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:6',
            'estado' => 'required|in:Activo,Inactivo',
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:100'
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.'
        ]);

        // Crear usuario (siempre como Usuario, no Administrador)
        $usuario = Usuario::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'Usuario', // Siempre Usuario
            'estado' => $request->estado
        ]);

        // Crear información del usuario
        UsuarioInfo::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'id_usuario' => $usuario->id_usuario
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = Usuario::with('usuarioInfo')->findOrFail($id);
        
        // Verificar que no sea administrador
        if ($usuario->rol === 'Administrador') {
            abort(403, 'No tienes permisos para ver este usuario.');
        }
        
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = Usuario::with('usuarioInfo')->findOrFail($id);
        
        // Verificar que no sea administrador
        if ($usuario->rol === 'Administrador') {
            abort(403, 'No tienes permisos para editar este usuario.');
        }
        
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::with('usuarioInfo')->findOrFail($id);
        
        // Verificar que no sea administrador
        if ($usuario->rol === 'Administrador') {
            abort(403, 'No tienes permisos para editar este usuario.');
        }

        $request->validate([
            'email' => 'required|email|unique:usuario,email,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:6',
            'estado' => 'required|in:Activo,Inactivo',
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:100'
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.'
        ]);

        // Actualizar usuario
        $usuarioData = [
            'email' => $request->email,
            'estado' => $request->estado
        ];

        if ($request->password) {
            $usuarioData['password'] = Hash::make($request->password);
        }

        $usuario->update($usuarioData);

        // Actualizar información del usuario
        $usuario->usuarioInfo->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Verificar que no sea administrador
        if ($usuario->rol === 'Administrador') {
            abort(403, 'No tienes permisos para eliminar este usuario.');
        }

        $usuario->delete(); // Esto eliminará también la información del usuario por CASCADE

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}