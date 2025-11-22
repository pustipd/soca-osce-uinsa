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
        // dd(Auth::guard('web')->check());

        $penguji_id = auth('penguji')->user()->id;

        // dd($penguji_id);

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

        $peserta = PesertaSoca::find($id);

        return view('ujian.soca.hasil_ujian', [
            'peserta' => $peserta
        ]);
    }

    public function examJudgmentSoca(Request $request)
    {

        $penguji_id = auth('penguji')->user()->id;
        $peserta = PesertaSoca::find($request->id_peserta);

        $list_indikator = IndikatorSoca::where("id_kriteria", $request->id_kriteria)->pluck('id')->toArray();

        foreach($list_indikator as $key => $indikator) {

            $hasil = HasilUjianSoca::where("id_peserta_soca", $request->id_peserta)->where("id_indikator_soca", $indikator)->first();

            if(! $hasil) {
                $hasil = new HasilUjianSoca();
            }

            $hasil->id_peserta_soca = $request->id_peserta;
            $hasil->id_indikator_soca = $indikator;

            if($peserta->id_penguji1 == $penguji_id) {
                $hasil->skor1 = $request->nilai[$key];
            } else if($peserta->id_penguji2 == $penguji_id) {
                $hasil->skor2 = $request->nilai[$key];
            } else{
                $hasil->skor1 = $request->nilai[$key];
                $hasil->skor2 = $request->nilai[$key];
            }
            $hasil->save();
        }

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

            // if($peserta) {
            $hasil->skor = $request->nilai[$key];
            // } else {
            // $hasil->skor2 = $request->nilai[$key];
            // }
            $hasil->bobot = $indikator->bobot;

            $hasil->save();
        }

        return redirect('osce/penguji/list-ujian');
    }
}
