<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\IndikatorSoca;
use App\Models\KriteriaSoca;
use App\Models\UjianSoca;

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
        $list_ujian = UjianSoca::all();
        return view('master.soca.indikator.create', [
            'list_ujian' => $list_ujian
        ]);
    }

    public function store(Request $request)
    {
        $indikator = new IndikatorSoca();
        $indikator->nama = $request->nama;
        $indikator->id_ujian = $request->id_ujian;
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

        $list_ujian = UjianSoca::all();

        return view('master.soca.indikator.edit', [
            "indikator" => $indikator,
            "list_ujian" => $list_ujian
        ]);
    }

    public function update($id, Request $request)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('soca/indikator');
        }

        $indikator->nama = $request->nama;
        $indikator->id_ujian = $request->id_ujian;
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
