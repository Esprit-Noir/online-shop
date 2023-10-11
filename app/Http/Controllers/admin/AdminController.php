<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index():View
    {
        return \view('admin.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()){
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $admin = Auth::guard('admin')->user();
                if ($admin->role == 1){
                    return redirect()->route('admin.home');
                }else{
                    Auth::guard('admin')->logout();
                    return redirect()->back()->with('error','You are not authorized to access admin panel.');
                }
            }else{
                return redirect()->back()->with('error','Email or Password incorrect!');
            }
        }else{
            return redirect()->back()->withErrors($validator)->withInput($request->only('email'));
        }
    }



}
