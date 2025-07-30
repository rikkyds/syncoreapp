<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $view = 'dashboards.' . $user->role->name;
        
        // Fallback to default dashboard if view doesn't exist
        if (!view()->exists($view)) {
            $view = 'dashboard';
        }
        
        return view($view);
    }
}
