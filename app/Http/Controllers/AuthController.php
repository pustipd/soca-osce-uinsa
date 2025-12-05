<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
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

    public function changePassword()
    {
        $user = Auth::guard('penguji')->user();

        return view('auth.change_password', [
            "user" => $user
        ]);
    }

    public function doChangePassword(Request $request)
    {

        $user = Auth::guard('penguji')->user();

        $penguji = Penguji::find($user->id);

        if(! $penguji) {
            Session::flash("page_error", "Data tidak ditemukan");
            return redirect()->back();
        }

        if(Hash::check($request->password_saat_ini, $penguji->password)) {
            Session::flash("page_error", "Password saat ini tidak sesuai");
            return redirect()->back();
        }

        if($request->password_baru != $request->password_konfirmasi) {
            Session::flash("page_error", "Password baru dan password konfirmasi tidak sama");
            return redirect()->back();
        }

        $penguji->password = Hash::make($request->password_baru);
        $penguji->save();


        Session::flash("page_success", "Berhasi mengubah password");
        return redirect()->back();
    }
}
