<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\UsuarioInfo;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = Usuario::where('email', $request->email)
                      ->where('estado', 'Activo')
                      ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|min:2',
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:100'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 100 caracteres.'
        ]);

        // Crear usuario automáticamente como "Usuario"
        $usuario = Usuario::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'Usuario',
            'estado' => 'Activo'
        ]);

        // Crear información del usuario
        UsuarioInfo::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'id_usuario' => $usuario->id_usuario
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')
            ->with('success', '¡Registro exitoso! Bienvenido a Wurger.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();
        
        if ($user->rol === 'Administrador') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
