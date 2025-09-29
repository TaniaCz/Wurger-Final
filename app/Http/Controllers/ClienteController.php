<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioInfo;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = UsuarioInfo::with('usuario')
            ->whereHas('usuario', function($query) {
                $query->where('rol', 'Usuario');
            })
            ->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Display a listing of clients for viewing only (no CRUD)
     */
    public function ver()
    {
        $clientes = UsuarioInfo::with(['usuario', 'pedidos'])
            ->whereHas('usuario', function($query) {
                $query->where('rol', 'Usuario');
            })
            ->paginate(12);
        return view('clientes.ver', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|min:2',
            'telefono' => 'nullable|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'direccion' => 'nullable|string|max:100',
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:6',
            'estado' => 'required|in:Activo,Inactivo'
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.'
        ]);

        // Crear usuario
        $usuario = Usuario::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'Usuario',
            'estado' => $request->estado
        ]);

        // Crear información del usuario
        UsuarioInfo::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'id_usuario' => $usuario->id_usuario
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = UsuarioInfo::with(['usuario', 'pedidos'])
            ->whereHas('usuario', function($query) {
                $query->where('rol', 'Usuario');
            })
            ->findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = UsuarioInfo::with('usuario')
            ->whereHas('usuario', function($query) {
                $query->where('rol', 'Usuario');
            })
            ->findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = UsuarioInfo::with('usuario')
            ->whereHas('usuario', function($query) {
                $query->where('rol', 'Usuario');
            })
            ->findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:100|min:2',
            'telefono' => 'nullable|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'direccion' => 'nullable|string|max:100',
            'email' => 'required|email|unique:usuario,email,' . $cliente->usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|min:6',
            'estado' => 'required|in:Activo,Inactivo'
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.'
        ]);

        // Actualizar información del usuario
        $cliente->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        // Actualizar usuario
        $usuarioData = [
            'email' => $request->email,
            'estado' => $request->estado
        ];
        
        if ($request->password) {
            $usuarioData['password'] = Hash::make($request->password);
        }
        
        $cliente->usuario->update($usuarioData);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = UsuarioInfo::whereHas('usuario', function($query) {
            $query->where('rol', 'Usuario');
        })->findOrFail($id);
        
        $cliente->usuario->delete(); // Esto eliminará también la información del usuario por CASCADE

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}