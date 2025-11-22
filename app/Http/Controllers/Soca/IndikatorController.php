<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\IndikatorOsce;
use App\Models\KriteriaSoca;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikator = IndikatorOsce::all();

        return view('master.soca.indikator.index', [
            'indikator' => $indikator
        ]);
    }

    public function create()
    {
        $list_kriteria = KriteriaSoca::all();
        return view('master.soca.indikator.create', [
            'list_kriteria' => $list_kriteria
        ]);
    }

    public function store(Request $request)
    {
        $indikator = new IndikatorSoca();
        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->deskripsi = $request->deskripsi;
        $indikator->skormax = $request->skormax;
        $indikator->save();

        return redirect('indikator');
    }

    public function edit($id)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('indikator');
        }

        return view('master.soca.indikator.edit', [
            "indikator" => $indikator
        ]);
    }

    public function update($id, Request $request)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('indikator');
        }

        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->deskripsi = $request->deskripsi;
        $indikator->skormax = $request->skormax;
        $indikator->save();

        return redirect('indikator');

    }
}
