<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    function index()
    {
        return view("login");
    }
    function login(Request $request)
    {
        Session::flash('nrp', $request->nrp);
        $request->validate([
            'nrp' => 'required',
            'name' => 'required'
        ]);

        $nrp = $request->nrp;
        $name = $request->name;

        // Ambil auditor dari database berdasarkan NRP
        $auditor = User::where('nrp', $nrp)->first();

        if ($auditor && $auditor->name === $name) {
            $role = $auditor->role;
            session(['logged_in_auditor' => $name]);
            session(['logged_in_role' => $role]);
            // Otentikasi berhasil
            // Auth::login($auditor); // Login user
            return redirect('checksheetcasting');
        } else {
            // Otentikasi gagal
            Session::flash('login_failed', 'Login failed! Please enter the correct NRP and auditor name.');
            return back();
        }
    }
}
