<?php

namespace App\Http\Controllers\Osce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

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
        $indikator->jenis_indikator = $request->jenis_indikator;

        if($request->jenis_indikator == "deskripsi") {
            $indikator->deskripsi = $request->deskripsi;
        } else {
            if ($request->dokumen) {

                $filename = "indikator-" . rand(10, 99) . "-" . time() . "." .
                            $request->dokumen->getClientOriginalExtension();

                $file_path = "osce/indikator/" . $filename;

                Storage::disk("public")->put(
                    $file_path,
                    file_get_contents($request->dokumen)
                );

                $indikator->dokumen = $file_path;
            }


        }

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
        $indikator->jenis_indikator = $request->jenis_indikator;

        if($request->jenis_indikator == "deskripsi") {
            $indikator->deskripsi = $request->deskripsi;
        } else {

            if (isset($request->dokumen)) {

                if ($indikator->dokumen && Storage::disk('public')->exists($indikator->dokumen)) {
                    Storage::disk('public')->delete($indikator->dokumen);
                }

                $filename =  "indikator-" . rand(10, 99) . "-" . time() . "." . $request->dokumen->extension();
                $file_path =  "osce/indikator/" . $filename;

                Storage::disk("public")->put($file_path, file_get_contents($request->dokumen), 'public');
                $indikator->dokumen = $file_path;
            }

        }

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
