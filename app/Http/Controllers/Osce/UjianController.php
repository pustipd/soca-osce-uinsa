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

    public function listExamScheduled()
    {
        // $list_peserta = PesertaOsce::all();
        $list_peserta = PesertaOsce::with('stationOsce')
                    ->get()
                    ->groupBy('stationOsce.id_ujian_osce');

        return view('master.osce.ujian.exam_scheduled', [
            'list_peserta' => $list_peserta
        ]);
    }

    public function examScheduling()
    {
        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_station = StationOsce::all();
        $list_ujian = UjianOsce::all();

        return view('master.osce.ujian.penjadwalan', [
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_station' => $list_station,
            'list_ujian' => $list_ujian
        ]);
    }

    public function doExamScheduling(Request $request)
    {

        $list_station = StationOsce::where("id_ujian_osce", $request->id_ujian)->get();

        foreach($list_station as $station) {
            $peserta = new PesertaOsce();
            $peserta->id_mahasiswa = $request->id_mahasiswa;
            $peserta->id_station = $station->id;
            $peserta->save();
        }

        return redirect('osce/exam-scheduled');
    }

    public function editExamScheduled($id) {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/exam-scheduled');
        }

        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_station = StationOsce::all();
        $list_ujian = UjianOsce::all();

        $id_ujian = 0;

        if($peserta->stationOsce()->exists()) {
            $id_ujian = $peserta->stationOsce()->first()->id_ujian_osce;
        }

        return view('master.osce.ujian.edit_penjadwalan', [
            'peserta' => $peserta,
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_station' => $list_station,
            'list_ujian' => $list_ujian,
            'id_ujian' => $id_ujian
        ]);

    }


    public function updateExamScheduled($id, Request $request)
    {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/exam-scheduled');
        }

        $list_station = StationOsce::where('id_ujian_osce', $peserta->stationOsce->id_ujian_osce)->get();

        foreach($list_station as $station) {
            PesertaOsce::where("id_station", $station->id)->where("id_mahasiswa", $peserta->id_mahasiswa)->delete();
        }

        $list_station = StationOsce::where("id_ujian_osce", $request->id_ujian)->get();

        foreach($list_station as $station) {
            $peserta = new PesertaOsce();
            $peserta->id_mahasiswa = $request->id_mahasiswa;
            $peserta->id_station = $station->id;
            $peserta->save();
        }

        return redirect('osce/exam-scheduled');

    }

    public function deleteExamScheduled($id) {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/exam-scheduled');
        }

        $id_mahasiswa = $peserta->id_mahasiswa;

        if($peserta->hasilUjianOsce()->exists()) {
            return redirect('osce/exam-scheduled');
        }

        $list_station = StationOsce::where('id_ujian_osce', $peserta->stationOsce->id_ujian_osce)->get();

        foreach($list_station as $station) {
            PesertaOsce::where("id_station", $station->id)->where("id_mahasiswa", $id_mahasiswa)->delete();
        }

        return redirect('osce/exam-scheduled');

    }

    public function detailExamScheduled($id)
    {
        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/exam-scheduled');
        }

        $id_ujian = $peserta->stationOsce->id_ujian_osce;

        $list_station = StationOsce::where("id_ujian_osce", $id_ujian)->pluck('id')->toArray();

        $list_peserta = PesertaOsce::where("id_mahasiswa", $peserta->id_mahasiswa)->whereIn("id_station", $list_station)->get();

        return view('master.osce.ujian.detail_exam_scheduled', [
            'list_peserta' => $list_peserta
        ]);
    }
}
