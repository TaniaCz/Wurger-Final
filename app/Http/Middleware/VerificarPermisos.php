<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarPermisos
{
    public function handle(Request $request, Closure $next, $rol = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $usuario = Auth::user();
        
        if ($usuario->Estado_usuario !== 'Activo') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu cuenta está inactiva. Contacta al administrador.'
            ]);
        }
        
        if ($rol) {
            $rolesPermitidos = is_array($rol) ? $rol : explode('|', $rol);
            
            if (!in_array($usuario->rol->Nombre_rol, $rolesPermitidos)) {
                abort(403, 'No tienes permisos para acceder a esta sección.');
            }
        }
        
        return $next($request);
    }
}