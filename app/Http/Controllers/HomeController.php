<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the public index page
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Redirect authenticated users to appropriate dashboard
     */
    public function redirect()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->rol === 'Administrador') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }
        return redirect()->route('home');
    }
}

