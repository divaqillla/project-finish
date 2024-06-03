<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class SupplierAuthController extends Controller
{

    use Authenticatable;


    public function __construct()
    {
        Auth::setDefaultDriver('suppliers');
        // $this->middleware('suppliers');
    }


    public function login()
    {

        return view('layouts.supplier.login-supplier');
    }


    public function handleLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:5|max:30'
        ]);


        $request->session()->regenerate();

        if (Auth::guard('suppliers')->attempt($request->only(['username', 'password']))) {
            // return Auth::getDefaultDriver();

            return redirect()->route('dashboard.supplier');
        }


        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logoutsupplier(Request $request)
    {
        Auth::guard('suppliers')->logout();
        return redirect()->route('supplier.login');
    }

}
