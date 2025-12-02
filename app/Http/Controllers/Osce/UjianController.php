<?php

namespace App\Http\Controllers\Osce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\UjianOsce;
use App\Models\PesertaOsce;
use App\Models\Penguji;
use App\Models\Mahasiswa;
use App\Models\KriteriaOsce;
use App\Models\StationOsce;

class UjianController extends Controller
{
    public function index()
    {
        $ujian = UjianOsce::all();

        return view('master.osce.ujian.index', [
            'ujian' => $ujian
        ]);
    }

    public function create()
    {
        return view('master.osce.ujian.create',);
    }

    public function store(Request $request)
    {
        $ujian = new UjianOsce();
        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->kriteria = $request->kriteria;
        $ujian->status = 1;
        $ujian->save();

        return redirect('osce/ujian');
    }

    public function edit($id)
    {

        $ujian = UjianOsce::find($id);

        if(! $ujian){
            return redirect('osce/ujian');
        }

        return view('master.osce.ujian.edit', [
            "ujian" => $ujian
        ]);
    }

    public function update($id, Request $request)
    {
        $ujian = UjianOsce::find($id);

        if(! $ujian){
            return redirect('osce/ujian');
        }

        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->kriteria = $request->kriteria;
        $ujian->save();

        return redirect('osce/ujian');

    }

    public function delete($id)
    {
        $ujian = UjianOsce::find($id);

        if(! $ujian){
            return redirect('osce/ujian');
        }

        if($ujian->stationOsce()->exists()) {
            return redirect('osce/ujian');
        }

        $ujian->delete();
        return redirect('osce/ujian');
    }

    public function updateStatusUjian($id)
    {
        $ujian = UjianOsce::find($id);

        if(! $ujian){
            return response([
                "status" => "failed"
            ]);
        }

        if($ujian->status == 1) {
            $ujian->status = 0;
        } else {
            $ujian->status = 1;
        }

        $ujian->save();

        return response([
            'status' => "success"
        ]);
    }

}
