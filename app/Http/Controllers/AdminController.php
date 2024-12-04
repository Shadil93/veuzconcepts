<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class AdminController extends Controller
{
    //

    public function login(){
        return view('admin.login');
    }
 
    public function do_login(Request $request){
        $credentials = $request->only('email','password');
        if(Auth::guard('admin')->attempt($credentials)){
             $request->session()->regenerate();
             return redirect()->route('create');
        }
       return redirect()->route('login');
    }
    public function create(){
        return view('admin.create.create');
    }
}
