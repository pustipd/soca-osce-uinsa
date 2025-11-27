<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\UjianSoca;
use App\Models\PesertaSoca;
use App\Models\Penguji;
use App\Models\Mahasiswa;
use App\Models\KriteriaSoca;

class UjianController extends Controller
{
    public function index()
    {
        $ujian = UjianSoca::all();

        return view('master.soca.ujian.index', [
            'ujian' => $ujian
        ]);
    }

    public function create()
    {
        return view('master.soca.ujian.create');
    }

    public function store(Request $request)
    {
        $ujian = new UjianSoca();
        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        // $ujian->id_kriteria = $request->id_kriteria;
        $ujian->kriteria = $request->kriteria;
        $ujian->batasnilai = $request->batasnilai;
        $ujian->status = true;
        $ujian->save();

        return redirect('soca/ujian');
    }

    public function edit($id)
    {

        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('soca/ujian');
        }

        return view('master.soca.ujian.edit', [
            "ujian" => $ujian
        ]);
    }

    public function update($id, Request $request)
    {
        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('soca/ujian');
        }

        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->kriteria = $request->kriteria;
        $ujian->batasnilai = $request->batasnilai;
        $ujian->save();

        return redirect('soca/ujian');

    }

    public function delete($id)
    {
        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('soca/ujian');
        }

        if($ujian->pesertaSoca()->exists()) {
            return redirect('soca/ujian');
        }

        $ujian->delete();
        return redirect('soca/ujian');
    }

}
