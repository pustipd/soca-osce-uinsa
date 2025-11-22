<?php

namespace App\Http\Controllers\Osce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\KriteriaOsce;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaOsce::all();

        return view('master.osce.kriteria.index', [
            'kriteria' => $kriteria
        ]);
    }

    public function create()
    {
        return view('master.osce.kriteria.create');
    }

    public function store(Request $request)
    {
        $kriteria = new KriteriaOsce();
        $kriteria->nama = $request->nama;
        $kriteria->totalnilai = $request->totalnilai;
        $kriteria->save();

        return redirect('osce/kriteria');
    }

    public function edit($id)
    {
        $kriteria = KriteriaOsce::find($id);

        if(! $kriteria)
        {
            return redirect('osce/kriteria');
        }

        return view('master.osce.kriteria.edit', [
            "kriteria" => $kriteria
        ]);
    }

    public function update($id, Request $request)
    {
        $kriteria = KriteriaOsce::find($id);

        if(! $kriteria)
        {
            return redirect('osce/kriteria');
        }

        $kriteria->nama = $request->nama;
        $kriteria->totalnilai = $request->totalnilai;
        $kriteria->save();

        return redirect('osce/kriteria');

    }
}
