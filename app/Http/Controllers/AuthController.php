<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

// Models
use App\Models\User;
use App\Models\Penguji;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {

        $type = "admin";

        $user = User::where("email", $request->username)->first();

        if(! $user) {
            $type = "penguji";

            $user = Penguji::where("nip", $request->username)->first();
        }

        if(! $user) {
            Session::flash('page_error', 'username / password tidak sesuai');
            return redirect()->back();
        }

        if($type == "admin") {

            if(Auth::guard('web')->attempt([
                'email' => $request->username,
                'password' => $request->password
            ])) {
                // Session::flash("page_success", "Berhasil Login");
                return redirect('soca/ujian');
            }

        }

        if($type == "penguji") {
            if(Auth::guard('penguji')->attempt([
                'nip' => $request->username,
                'password' => $request->password
            ])) {
                // Session::flash("page_success", "Berhasil Login");
                return redirect('soca/penguji/list-ujian');
            }
        }

        Session::flash('page_error', 'username / password tidak sesuai');
        return redirect()->back();
    }
}
