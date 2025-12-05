<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Penguji;

class APIController extends Controller
{
    public function resetPasswordPengujiAll()
    {
        $list_penguji = Penguji::all();

        foreach($list_penguji as $penguji) {
            $penguji->password = Hash::make($penguji->nidn);
            $penguji->save();
        }

        return response([
            "status" => "success"
        ]);
    }

    public function resetPasswordPengujiById($id, Request $request)
    {
        $penguji = Penguji::find($id);

        if(! $penguji) {
            return response([
                "status" => "not-found",
                "message" => "Data penguji tidak ditemukan"
            ], 404);
        }

        if(! $request->password) {
            return resposne([
                "status" => "invalid",
                "message" => "Parameter password harus ada"
            ], 400);
        }

        $penguji->password = Hash::make($request->password);
        $penguji->save();

        return response([
            "status" => "success"
        ]);
    }
}
