<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        if($request->type == "admin") {

            $admin = \App\Models\User::where('email', $request->username)
                        ->first();

            if ($admin) {
                Auth::guard('web')->login($admin);
                return redirect('soca/ujian');
            }
        } else {

            $penguji = \App\Models\Penguji::where('nip', $request->username)
                        ->first();

            if ($penguji) {
                Auth::guard('penguji')->login($penguji);
                return redirect('soca/penguji/list-ujian');
            }

        }

        return redirect('login');
    }
}
