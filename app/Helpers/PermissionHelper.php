<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function canAccess($module)
    {
        if (!Auth::check()) {
            return false;
        }
        
        $usuario = Auth::user();
        $rol = $usuario->rol->Nombre_rol ?? 'Sin rol';
        
        $permisos = [
            'Administrador' => [
                'usuarios', 'productos', 'ventas', 'clientes', 'categorias', 
                'inventario', 'reportes', 'busqueda', 'notificaciones'
            ],
            'Cocinero' => [
                'productos', 'ventas', 'inventario', 'notificaciones'
            ],
            'Mesero' => [
                'ventas', 'clientes', 'notificaciones'
            ],
            'Cajero' => [
                'ventas', 'clientes', 'notificaciones'
            ]
        ];
        
        return in_array($module, $permisos[$rol] ?? []);
    }
    
    public static function canCreate($module)
    {
        if (!Auth::check()) {
            return false;
        }
        
        $usuario = Auth::user();
        $rol = $usuario->rol->Nombre_rol ?? 'Sin rol';
        
        $permisos = [
            'Administrador' => [
                'usuarios', 'productos', 'ventas', 'clientes', 'categorias'
            ],
            'Cocinero' => [
                'productos', 'ventas'
            ],
            'Mesero' => [
                'ventas', 'clientes'
            ],
            'Cajero' => [
                'ventas', 'clientes'
            ]
        ];
        
        return in_array($module, $permisos[$rol] ?? []);
    }
    
    public static function canEdit($module)
    {
        if (!Auth::check()) {
            return false;
        }
        
        $usuario = Auth::user();
        $rol = $usuario->rol->Nombre_rol ?? 'Sin rol';
        
        $permisos = [
            'Administrador' => [
                'usuarios', 'productos', 'ventas', 'clientes', 'categorias'
            ],
            'Cocinero' => [
                'productos', 'ventas'
            ],
            'Mesero' => [
                'ventas', 'clientes'
            ],
            'Cajero' => [
                'ventas', 'clientes'
            ]
        ];
        
        return in_array($module, $permisos[$rol] ?? []);
    }
    
    public static function canDelete($module)
    {
        if (!Auth::check()) {
            return false;
        }
        
        $usuario = Auth::user();
        $rol = $usuario->rol->Nombre_rol ?? 'Sin rol';
        
        $permisos = [
            'Administrador' => [
                'usuarios', 'productos', 'ventas', 'clientes', 'categorias'
            ],
            'Cocinero' => [
                'productos'
            ],
            'Mesero' => [
                'ventas', 'clientes'
            ],
            'Cajero' => [
                'ventas', 'clientes'
            ]
        ];
        
        return in_array($module, $permisos[$rol] ?? []);
    }
    
    public static function getRoleName()
    {
        if (!Auth::check()) {
            return 'Sin rol';
        }
        
        return Auth::user()->rol->Nombre_rol ?? 'Sin rol';
    }
    
    public static function isAdmin()
    {
        return self::getRoleName() === 'Administrador';
    }
    
    public static function isCocinero()
    {
        return self::getRoleName() === 'Cocinero';
    }
    
    public static function isMesero()
    {
        return self::getRoleName() === 'Mesero';
    }
    
    public static function isCajero()
    {
        return self::getRoleName() === 'Cajero';
    }
}
