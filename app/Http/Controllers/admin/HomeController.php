<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index():View
    {
        $user = Auth::guard('admin')->user();
        return \view('admin.dashboard.home', compact('user'));
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login'); // Rediriger vers la page de connexion après la déconnexion
    }

}
