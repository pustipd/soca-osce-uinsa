<?php

namespace App\Http\Controllers\Osce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\IndikatorOsce;
use App\Models\KriteriaOsce;
use App\Models\UjianOsce;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikator = IndikatorOsce::all();

        return view('master.osce.indikator.index', [
            'indikator' => $indikator
        ]);
    }

    public function create()
    {
        $list_kriteria = KriteriaOsce::all();
        return view('master.osce.indikator.create', [
            'list_kriteria' => $list_kriteria
        ]);
    }

    public function store(Request $request)
    {
        $indikator = new IndikatorOsce();
        $indikator->nama = $request->nama;
        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->deskripsi = $request->deskripsi;
        $indikator->skormax = $request->skormax;
        $indikator->bobot = $request->bobot;
        $indikator->save();

        return redirect('osce/indikator');
    }

    public function edit($id)
    {
        $indikator = IndikatorOsce::find($id);

        if(! $indikator)
        {
            return redirect('osce/indikator');
        }
        $list_ujian = UjianOsce::all();

        return view('master.osce.indikator.edit', [
            "indikator" => $indikator,
            "list_ujian" => $list_ujian
        ]);
    }

    public function update($id, Request $request)
    {
        $indikator = IndikatorOsce::find($id);

        if(! $indikator)
        {
            return redirect('osce/indikator');
        }

        $indikator->nama = $request->nama;
        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->deskripsi = $request->deskripsi;
        $indikator->skormax = $request->skormax;
        $indikator->bobot = $request->bobot;
        $indikator->save();

        return redirect('osce/indikator');

    }

    public function delete($id)
    {

        $indikator = IndikatorOsce::find($id);

        if(! $indikator)
        {
            return redirect('osce/indikator');
        }

        if($indikator->hasilUjianOsce()->exists()) {
            return redirect('osce/indikator');
        }

        $indikator->delete();
        return redirect('osce/indikator');
    }
}
