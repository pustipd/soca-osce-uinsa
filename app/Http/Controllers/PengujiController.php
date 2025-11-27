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
use App\Models\UjianSoca;
use App\Models\StationOsce;
use App\Models\PengujiSoca;
use Auth;

class PengujiController extends Controller
{
    public function index()
    {

        $penguji_id = auth('penguji')->user()->id;
        $list_penguji = PengujiSoca::where("id_penguji1", $penguji_id)->orWhere("id_penguji2", $penguji_id)->get();

        return view('ujian.soca.list_ujian', [
            "list_penguji" => $list_penguji
        ]);
    }

    public function exam($id)
    {
        $penguji = PengujiSoca::find($id);

        if(! $penguji) {
            return redirect('penguji/list-ujian');
        }

        $tipe_penguji = 1;

        if(auth('penguji')->user()->id == $penguji->id_penguji2) {
            $tipe_penguji = 2;
        }

        $list_peserta = PesertaSoca::where("id_penguji_soca", $penguji->id)->get();

        $list_indikator = IndikatorSoca::where("id_kriteria", $penguji->id_kriteria)->get();

        return view ('ujian.soca.index2', [
            'list_peserta' => $list_peserta,
            'penguji' => $penguji,
            'tipe_penguji' => $tipe_penguji,
            "list_indikator" => $list_indikator
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

        $list_indikator = IndikatorSoca::where("id_ujian", $request->id_ujian)->pluck('id')->toArray();

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
            'peserta' => $peserta
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

        $list_indikator = IndikatorOsce::where("id_ujian", $request->id_ujian)->get();

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
        $peserta->feedback = $request->feedback;
        $peserta->save();

        return redirect('osce/penguji/list-ujian');
    }

    public function checkGapPoint(Request $request)
    {
        $peserta = PesertaSoca::find($request->id_peserta);

        if(! $peserta) {
            return response([
                "status" => "not-found"
            ]);
        }

        $total_nilai1 = 0;
        $total_nilai2 = 0;

        foreach($request->indikator as $key => $data) {

            $hasil = HasilUjianSoca::where("id_peserta_soca", $request->id_peserta)->where("id_indikator_soca", $data)->first();

            if(! $hasil) {
                $hasil = new HasilUjianSoca();
            }

            $hasil->id_peserta_soca = $request->id_peserta;
            $hasil->id_indikator_soca = $data;

            if($request->tipe_penguji == 1) {
                $hasil->skor1 = $request->nilai[$key];
                $total_nilai1 += $request->nilai[$key];

                if($hasil->skor2) {
                    $total_nilai2 += $hasil->skor2;
                }

            } else {
                $hasil->skor2 = $request->nilai[$key];
                $total_nilai2 += $request->nilai[$key];

                if(isset($hasil->skor1)) {
                    $total_nilai1 += $hasil->skor1;
                }

            }

            $hasil->save();

        }

        $ujian = UjianSoca::find($peserta->id_ujian_soca);

        if(abs($total_nilai1 - $total_nilai2) > $ujian->batasnilai) {
            return response([
                "status" => "failed"
            ]);
        }

        return response([
            "status" => "success"
        ]);
    }

    public function mahasiswaAbsenSoca($id)
    {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/penguji/list-ujian');
        }

        $peserta->status = "tidak hadir";
        $peserta->save();

        return redirect('soca/penguji/list-ujian');
    }

    public function mahasiswaAbsenOsce($id)
    {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penguji/list-ujian');
        }

        $peserta->status = "tidak hadir";
        $peserta->save();

        return redirect('osce/penguji/list-ujian');
    }

    public function checkStation($id)
    {

        $peserta = PesertaOsce::find($id);

        if($peserta->status == 'aktif') {
            $peserta->status = "penilaian";
            $peserta->save();
        }

        $is_complete = true;

        $rotasi = $peserta->rotasi;

        $list_station = StationOsce::where("id_ujian_osce", $peserta->stationOsce->id_ujian_osce)->pluck('id')->toArray();
        $list_peserta = PesertaOsce::where("id_mahasiswa", '!=', $peserta->id_mahasiswa)->whereIn("id_station", $list_station)->where('rotasi', $rotasi)->get();

        foreach($list_peserta as $item) {
            if($item->status != 'penilaian') {
                $is_complete = false;
            }
        }

        if($is_complete) {
            return response([
                'status' => "complete"
            ]);
        }

        return response([
            'status' => 'not-complete'
        ]);

    }
}
