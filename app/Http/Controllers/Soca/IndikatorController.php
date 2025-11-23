<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\IndikatorSoca;
use App\Models\KriteriaSoca;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikator = IndikatorSoca::all();

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

        return redirect('soca/indikator');
    }

    public function edit($id)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('soca/indikator');
        }

        $list_kriteria = KriteriaSoca::all();

        return view('master.soca.indikator.edit', [
            "indikator" => $indikator,
            "list_kriteria" => $list_kriteria
        ]);
    }

    public function update($id, Request $request)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('soca/indikator');
        }

        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->deskripsi = $request->deskripsi;
        $indikator->skormax = $request->skormax;
        $indikator->save();

        return redirect('soca/indikator');

    }

    public function delete($id)
    {

        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('soca/indikator');
        }

        if($indikator->hasilUjianSoca()->exists()) {
            return redirect('soca/indikator');
        }

        $indikator->delete();

        return redirect('soca/indikator');
    }
}
