<?php

namespace App\Http\Controllers\Soca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

// models
use App\Models\PengujiSoca;
use App\Models\Mahasiswa;
use App\Models\Penguji;
use App\Models\UjianSoca;
use App\Models\KriteriaSoca;
use App\Models\PesertaSoca;

// Import
use App\Imports\PenjadwalanSoca;

class PenjadwalanController extends Controller
{

    public function index()
    {

        $list_penguji = PengujiSoca::all();

        return view('master.soca.penjadwalan.index', [
            'list_penguji' => $list_penguji
        ]);
    }

    public function create()
    {
        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_ujian = UjianSoca::all();
        $list_kriteria = KriteriaSoca::all();

        return view('master.soca.penjadwalan.create', [
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_ujian' => $list_ujian,
            "list_kriteria" => $list_kriteria
        ]);
    }

    public function store(Request $request)
    {
        $penguji = new PengujiSoca();
        $penguji->id_kriteria = $request->id_kriteria;
        $penguji->id_penguji1 = $request->id_penguji1;
        $penguji->id_penguji2 = $request->id_penguji2;
        $penguji->id_ujian_soca = $request->id_ujian_soca;
        $penguji->station = $request->station;
        $penguji->save();

        return redirect('soca/penjadwalan');
    }

    public function edit($id) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/penjadwalan');
        }

        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_ujian = UjianSoca::all();

        return view('master.soca.penjadwalan.edit', [
            'peserta' => $peserta,
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_ujian' => $list_ujian
        ]);

    }

    public function update($id, Request $request) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/penjadwalan');
        }

        $peserta->id_mahasiswa = $request->id_mahasiswa;
        $peserta->id_penguji1 = $request->id_penguji1;
        $peserta->id_penguji2 = $request->id_penguji2;
        $peserta->id_ujian_soca = $request->id_ujian_soca;
        $peserta->save();

        return redirect('soca/penjadwalan');

    }


    public function delete($id) {

        $peserta = PesertaSoca::find($id);

        if(! $peserta) {
            return redirect('soca/penjadwalan');
        }

        if($peserta->hasilUjianSoca()->exists()) {
            return redirect('soca/penjadwalan');
        }

        $peserta->delete();
        return redirect('soca/penjadwalan');

    }

    public function mappingWithMahasiswa($id)
    {
        $penguji = PengujiSoca::find($id);

        if(! $penguji) {
            return redirect('soca/penguji');
        }

        $list_mahasiswa = Mahasiswa::all();

        $peserta = PesertaSoca::where("id_penguji_soca", $penguji->id)->get();
        $list_peserta = [];

        if($peserta) {
            $list_peserta = $peserta;
        }

        return view('master.soca.penjadwalan.mapping', [
            'penguji' => $penguji,
            "list_mahasiswa" => $list_mahasiswa,
            "list_peserta" => $list_peserta
        ]);
    }

    public function doMappingWithMahasiswa(Request $request)
    {

        if(count($request->mahasiswa) != count(array_unique($request->mahasiswa))) {
            return redirect('soca/penjadwalan');
        }

        if(count($request->urutan) != count(array_unique($request->urutan))) {
            return redirect('soca/penjadwalan');
        }

        foreach($request->mahasiswa as $key => $mahasiswa) {

            $peserta = new PesertaSoca();
            $peserta->id_mahasiswa = $mahasiswa;
            $peserta->id_penguji_soca = $request->id_penguji;
            $peserta->urutan = $request->urutan[$key];
            $peserta->save();

        }

        return redirect('soca/penjadwalan');
    }

    public function importDataMahasiswa(Request $request)
    {
        // return 'ok';

        try {

            $collection = Excel::toCollection(new PenjadwalanSoca, $request->file('import_mahasiswa'));

            $nims = $collection[0]->pluck('nim');

            $list_mahasiswa = Mahasiswa::whereIn("nim", $nims)->get();

            if(count($list_mahasiswa) < 1) {
                return response([
                    "status" => "not-found"
                ]);
            }

            return response([
                "status" => "success",
                "data" => $list_mahasiswa
            ]);

        } catch (\Throwable $th) {

            return response([
                "status" => "failed"
            ]);

        }

    }
}
