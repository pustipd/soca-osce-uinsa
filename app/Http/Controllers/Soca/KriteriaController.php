<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\KriteriaSoca;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaSoca::all();

        return view('master.soca.kriteria.index', [
            'kriteria' => $kriteria
        ]);
    }

    public function create()
    {
        return view('master.soca.kriteria.create');
    }

    public function store(Request $request)
    {
        $kriteria = new KriteriaSoca();
        $kriteria->nama = $request->nama;
        $kriteria->totalnilai = $request->totalnilai;
        $kriteria->save();

        return redirect('kriteria');
    }

    public function edit($id)
    {
        $kriteria = KriteriaSoca::find($id);

        if(! $kriteria)
        {
            return redirect('kriteria');
        }

        return view('master.soca.kriteria.edit', [
            "kriteria" => $kriteria
        ]);
    }

    public function update($id, Request $request)
    {
        $kriteria = KriteriaSoca::find($id);

        if(! $kriteria)
        {
            return redirect('kriteria');
        }

        $kriteria->nama = $request->nama;
        $kriteria->totalnilai = $request->totalnilai;
        $kriteria->save();

        return redirect('kriteria');

    }
}
