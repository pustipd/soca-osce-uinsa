<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\UjianSoca;
use App\Models\PesertaSoca;
use App\Models\PengujiSoca;
use App\Models\Mahasiswa;

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
        $ujian->kriteria = $request->kriteria;
        $ujian->batasnilai = $request->batasnilai;
        $ujian->save();

        return redirect('ujian');
    }

    public function edit($id)
    {

        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('ujian');
        }

        return view('master.soca.ujian.edit', [
            "ujian" => $ujian
        ]);
    }

    public function update($id, Request $request)
    {
        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('ujian');
        }

        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->kriteria = $request->kriteria;
        $ujian->batasnilai = $request->batasnilai;
        $ujian->save();

        return redirect('ujian');

    }

    public function listExamScheduled()
    {

        $list_peserta = PesertaSoca::all();

        return view('master.soca.ujian.exam_scheduled', [
            'list_peserta' => $list_peserta
        ]);
    }

    public function examScheduling()
    {
        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = PengujiSoca::all();
        $list_ujian = UjianSoca::all();

        return view('master.soca.ujian.penjadwalan', [
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_ujian' => $list_ujian
        ]);
    }

    public function doExamScheduling(Request $request)
    {
        $peserta = new PesertaSoca();
        $peserta->id_mahasiswa = $request->id_mahasiswa;
        $peserta->id_penguji1 = $request->id_penguji1;
        $peserta->id_penguji2 = $request->id_penguji2;
        $peserta->id_ujian_soca = $request->id_ujian_soca;
        $peserta->save();

        return redirect('exam-scheduled');
    }
}
