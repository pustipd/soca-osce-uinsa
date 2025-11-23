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
        $list_kriteria = KriteriaSoca::all();

        return view('master.soca.ujian.create', [
            'list_kriteria' => $list_kriteria
        ]);
    }

    public function store(Request $request)
    {
        $ujian = new UjianSoca();
        $ujian->nama = $request->nama;
        $ujian->sesi = $request->sesi;
        $ujian->waktu = $request->waktu;
        $ujian->id_kriteria = $request->id_kriteria;
        $ujian->batasnilai = $request->batasnilai;
        $ujian->save();

        return redirect('soca/ujian');
    }

    public function edit($id)
    {

        $ujian = UjianSoca::find($id);

        if(! $ujian){
            return redirect('soca/ujian');
        }
        $list_kriteria = KriteriaSoca::all();

        return view('master.soca.ujian.edit', [
            "ujian" => $ujian,
            "list_kriteria" => $list_kriteria
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
        $ujian->id_kriteria = $request->id_kriteria;
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
        $list_penguji = Penguji::all();
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

        return redirect('soca/exam-scheduled');
    }

    public function editExamScheduled($id) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/exam-scheduled');
        }

        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_ujian = UjianSoca::all();

        return view('master.soca.ujian.edit_penjadwalan', [
            'peserta' => $peserta,
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_ujian' => $list_ujian
        ]);

    }


    public function updateExamScheduled($id, Request $request) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/exam-scheduled');
        }

        $peserta->id_mahasiswa = $request->id_mahasiswa;
        $peserta->id_penguji1 = $request->id_penguji1;
        $peserta->id_penguji2 = $request->id_penguji2;
        $peserta->id_ujian_soca = $request->id_ujian_soca;
        $peserta->save();

        return redirect('soca/exam-scheduled');

    }


    public function deleteExamScheduled($id) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/exam-scheduled');
        }

        if($peserta->hasilUjianSoca()->exists()) {
            return redirect('soca/exam-scheduled');
        }

        $peserta->delete();
        return redirect('soca/exam-scheduled');

    }
}
