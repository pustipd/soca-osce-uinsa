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

        $list_kriteria = KriteriaOsce::all();

        return view('master.osce.ujian.create', [
            "list_kriteria" => $list_kriteria
        ]);
    }

    public function store(Request $request)
    {
        $ujian = new UjianOsce();
        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->id_kriteria = $request->kriteria;
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
        $ujian->batasnilai = $request->batasnilai;
        $ujian->save();

        return redirect('osce/ujian');

    }

    public function listExamScheduled()
    {

        $list_peserta = PesertaOsce::all();

        return view('master.osce.ujian.exam_scheduled', [
            'list_peserta' => $list_peserta
        ]);
    }

    public function examScheduling()
    {
        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_station = StationOsce::all();

        return view('master.osce.ujian.penjadwalan', [
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_station' => $list_station
        ]);
    }

    public function doExamScheduling(Request $request)
    {
        $peserta = new PesertaOsce();
        $peserta->id_mahasiswa = $request->id_mahasiswa;
        $peserta->id_station = $request->id_station;
        $peserta->save();

        return redirect('osce/exam-scheduled');
    }
}
