<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\IndikatorSoca;
use App\Models\KriteriaSoca;
use App\Models\UjianSoca;
use App\Models\KategoriSoca;

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
        $list_kategori = KategoriSoca::all();

        return view('master.soca.indikator.create', [
            'list_kriteria' => $list_kriteria,
            "list_kategori" => $list_kategori
        ]);
    }

    public function store(Request $request)
    {
        $indikator = new IndikatorSoca();
        // $indikator->nama = $request->nama;
        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->id_kategori = $request->id_kategori;
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
        $list_kategori = KategoriSoca::all();

        return view('master.soca.indikator.edit', [
            "indikator" => $indikator,
            "list_kriteria" => $list_kriteria,
            "list_kategori" => $list_kategori
        ]);
    }

    public function update($id, Request $request)
    {
        $indikator = IndikatorSoca::find($id);

        if(! $indikator)
        {
            return redirect('soca/indikator');
        }

        // $indikator->nama = $request->nama;
        $indikator->id_kriteria = $request->id_kriteria;
        $indikator->id_kategori = $request->id_kategori;
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
