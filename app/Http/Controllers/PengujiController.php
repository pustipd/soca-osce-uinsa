<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\PesertaSoca;
use App\Models\PesertaOsce;
use App\Models\IndikatorSoca;
use App\Models\HasilUjianSoca;
use App\Models\IndikatorOsce;
use App\Models\HasilUjianOsce;
use Auth;

class PengujiController extends Controller
{
    public function index()
    {

        $penguji_id = auth('penguji')->user()->id;
        $list_ujian = PesertaSoca::with('ujianSoca.kriteriaSoca')->where("id_penguji1", $penguji_id)->orWhere("id_penguji2", $penguji_id)->get();

        return view('ujian.soca.list_ujian', [
            "list_ujian" => $list_ujian
        ]);
    }

    public function exam($id)
    {
        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('penguji/list-ujian');
        }

        return view ('ujian.soca.index', [
            'ujian' => $peserta
        ]);
    }

    public function hasilUjianSoca($id)
    {
        // dd(auth('penguji')->user()->id);
        $peserta = PesertaSoca::find($id);

        return view('ujian.soca.hasil_ujian', [
            'peserta' => $peserta
        ]);
    }

    public function updateHasilUjianSoca(Request $request)
    {
        $hasil = HasilUjianSoca::find($request->id_ujian);

        if(! $hasil) {
            return redirect('soca/penguji/hasil-ujian' . $hasil->id_peserta_soca);
        }

        if(isset($request->skor1)) {
            $hasil->skor1 = $request->skor1;
        } else {
            $hasil->skor2 = $request->skor2;
        }
        $hasil->save();

        $list_hasil = HasilUjianSoca::where("id_peserta_soca", $hasil->id_peserta_soca)->get();

        $total_nilai1 = 0;
        $total_nilai2 = 0;

        foreach($list_hasil as $hasil) {

            if($hasil->skor1) {
                $total_nilai1 += $hasil->skor1;
            }

            if($hasil->skor2) {
                $total_nilai2 += $hasil->skor2;
            }

        }

        $peserta = PesertaSoca::find($hasil->id_peserta_soca);
        $batas_nilai = $peserta->ujianSoca->batasnilai;
        // dd($hasil->id_peserta_soca);
        if(abs($total_nilai1 - $total_nilai2) <= $batas_nilai) {
            $peserta->status = "sinkron";
            $peserta->save();
        }

        return redirect('soca/penguji/hasil-ujian/' . $hasil->id_peserta_soca);
    }

    public function examJudgmentSoca(Request $request)
    {

        $penguji_id = auth('penguji')->user()->id;
        $peserta = PesertaSoca::find($request->id_peserta);

        $is_new = false;
        $is_done = false;
        $total_nilai1 = 0;
        $total_nilai2 = 0;

        $list_indikator = IndikatorSoca::where("id_kriteria", $request->id_kriteria)->pluck('id')->toArray();

        foreach($list_indikator as $key => $indikator) {

            $hasil = HasilUjianSoca::where("id_peserta_soca", $request->id_peserta)->where("id_indikator_soca", $indikator)->first();

            if(! $hasil) {
                $hasil = new HasilUjianSoca();
                $is_new = true;
            }

            $hasil->id_peserta_soca = $request->id_peserta;
            $hasil->id_indikator_soca = $indikator;

            if($peserta->id_penguji1 == $penguji_id) {
                $hasil->skor1 = $request->nilai[$key];
                if($hasil->skor2) {
                    $is_done = true;
                    $total_nilai1 += $hasil->skor1;
                    $total_nilai2 += $hasil->skor2;
                }
            } else if($peserta->id_penguji2 == $penguji_id) {
                $hasil->skor2 = $request->nilai[$key];
                if($hasil->skor1) {
                    $is_done = true;
                    $total_nilai1 += $hasil->skor1;
                    $total_nilai2 += $hasil->skor2;
                }
            } else{
                $hasil->skor1 = $request->nilai[$key];
                $hasil->skor2 = $request->nilai[$key];
                $is_done = true;
            }

            $hasil->save();
        }

        if($is_new) {
            $peserta->status = "sedang";
        }

        if($is_done) {
            $batas_nilai = $peserta->ujianSoca->batasnilai;

            if(abs($total_nilai1 - $total_nilai2) > $batas_nilai) {
                $peserta->status = "tidak sinkron";
            } else {
                $peserta->status = "sinkron";
            }

        }

        $peserta->save();

        return redirect('soca/penguji/list-ujian');
    }

    public function listUjianOsce()
    {

        $penguji_id = auth('penguji')->user()->id;

        $list_ujian = PesertaOsce::whereHas('stationOsce', function($q) use ($penguji_id) {
            $q->where('id_penguji', $penguji_id);
        })->get();

        return view('ujian.osce.list_ujian', [
            "list_ujian" => $list_ujian
        ]);
    }

    public function ujianOsce($id)
    {
        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penguji/list-ujian');
        }

        $peserta->status = "aktif";
        $peserta->save();

        return view ('ujian.osce.index', [
            'ujian' => $peserta
        ]);

    }

    public function hasilUjianOsce($id)
    {

        $peserta = PesertaOsce::find($id);

        return view('ujian.osce.hasil_ujian', [
            'peserta' => $peserta
        ]);
    }

    public function examJudgmentOsce(Request $request)
    {

        $peserta = PesertaOsce::find($request->id_peserta);

        $list_indikator = IndikatorOsce::where("id_kriteria", $request->id_kriteria)->get();

        foreach($list_indikator as $key => $indikator) {

            $hasil = HasilUjianOsce::where("id_peserta_osce", $request->id_peserta)->where("id_indikator_osce", $indikator->id)->first();

            if(! $hasil) {
                $hasil = new HasilUjianOsce();
            }

            $hasil->id_peserta_osce = $request->id_peserta;
            $hasil->id_indikator_osce = $indikator->id;

            $hasil->skor = $request->nilai[$key];
            $hasil->bobot = $indikator->bobot;

            $hasil->save();
        }

        $peserta->status = "selesai";
        $peserta->save();

        return redirect('osce/penguji/list-ujian');
    }
}
