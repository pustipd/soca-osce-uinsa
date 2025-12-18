<?php

namespace App\Http\Controllers\Osce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

// Models
use App\Models\PesertaOsce;
use App\Models\Mahasiswa;
use App\Models\Penguji;
use App\Models\StationOsce;
use App\Models\UjianOsce;

// Import
use App\Imports\PenjadwalanSoca;

class PenjadwalanController extends Controller
{

    public function index()
    {
        // $list_peserta = PesertaOsce::all();
        $list_peserta = PesertaOsce::with('stationOsce')
                    ->get()
                    ->groupBy('stationOsce.id_ujian_osce');


        $list_ujian = UjianOsce::whereHas('stationOsce')->get();

        return view('master.osce.penjadwalan.index', [
            'list_ujian' => $list_ujian
        ]);
    }

    public function create()
    {
        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_station = StationOsce::all();
        $list_ujian = UjianOsce::all();

        return view('master.osce.penjadwalan.create', [
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_station' => $list_station,
            'list_ujian' => $list_ujian
        ]);
    }

    public function store(Request $request)
    {

        $list_station = StationOsce::where("id_ujian_osce", $request->id_ujian)->get();

        foreach($list_station as $station) {
            $peserta = new PesertaOsce();
            $peserta->id_mahasiswa = $request->id_mahasiswa;
            $peserta->id_station = $station->id;
            $peserta->save();
        }

        return redirect('osce/penjadwalan');
    }

    public function edit($id) {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penjadwalan');
        }

        $list_mahasiswa = Mahasiswa::all();
        $list_penguji = Penguji::all();
        $list_station = StationOsce::all();
        $list_ujian = UjianOsce::all();

        $id_ujian = 0;

        if($peserta->stationOsce()->exists()) {
            $id_ujian = $peserta->stationOsce()->first()->id_ujian_osce;
        }

        return view('master.osce.penjadwalan.edit', [
            'peserta' => $peserta,
            'list_mahasiswa' => $list_mahasiswa,
            'list_penguji' => $list_penguji,
            'list_station' => $list_station,
            'list_ujian' => $list_ujian,
            'id_ujian' => $id_ujian
        ]);

    }

    public function update($id, Request $request)
    {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penjadwalan');
        }

        $list_station = StationOsce::where('id_ujian_osce', $peserta->stationOsce->id_ujian_osce)->get();

        foreach($list_station as $station) {
            PesertaOsce::where("id_station", $station->id)->where("id_mahasiswa", $peserta->id_mahasiswa)->delete();
        }

        $list_station = StationOsce::where("id_ujian_osce", $request->id_ujian)->get();

        foreach($list_station as $station) {
            $peserta = new PesertaOsce();
            $peserta->id_mahasiswa = $request->id_mahasiswa;
            $peserta->id_station = $station->id;
            $peserta->save();
        }

        return redirect('osce/penjadwalan');

    }

    public function delete($id) {

        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penjadwalan');
        }

        $id_mahasiswa = $peserta->id_mahasiswa;

        if($peserta->hasilUjianOsce()->exists()) {
            return redirect('osce/penjadwalan');
        }

        $list_station = StationOsce::where('id_ujian_osce', $peserta->stationOsce->id_ujian_osce)->get();

        foreach($list_station as $station) {
            PesertaOsce::where("id_station", $station->id)->where("id_mahasiswa", $id_mahasiswa)->delete();
        }

        return redirect('osce/penjadwalan');

    }

    public function detail($id)
    {
        $peserta = PesertaOsce::find($id);

        if(! $peserta) {
            return redirect('osce/penjadwalan');
        }

        $id_ujian = $peserta->stationOsce->id_ujian_osce;

        $list_station = StationOsce::where("id_ujian_osce", $id_ujian)->pluck('id')->toArray();

        $list_peserta = PesertaOsce::where("id_mahasiswa", $peserta->id_mahasiswa)->whereIn("id_station", $list_station)->get();

        return view('master.osce.penjadwalan.show', [
            'list_peserta' => $list_peserta
        ]);
    }

    public function mapping($id) {

        $ujian = UjianOsce::with('stationOsce.penguji')->find($id);

        if(! $ujian) {
            return redirect('osce/penjadwalan');
        }

        $list_mahasiswa = Mahasiswa::all();

        return view('master.osce.penjadwalan.mapping.index', [
            'ujian' => $ujian,
            "list_mahasiswa" => $list_mahasiswa
        ]);
    }

    public function doMapping(Request $request)
    {
        $ujian = UjianOsce::find($request->ujian_id);

        if(! $ujian) {
            return redirect('osce/penjadwalan');
        }

        $stations = $request->station_id;
        $mahasiswas = $request->mahasiswa_id;
        $count = count($stations);

        foreach ($mahasiswas as $mIndex => $mahasiswaId) {

            $data = [];

            for ($rotasi = 1; $rotasi <= $count; $rotasi++) {

                // station index = (mahasiswa index + rotasi - 1) mod count
                $stationIndex = ($mIndex + $rotasi - 1) % $count;

                $data[] = [
                    'id_station'   => $stations[$stationIndex],
                    'id_mahasiswa' => $mahasiswaId,
                    'rotasi'       => $rotasi,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ];
            }

            DB::connection('osce')->table('peserta_osce')->insert($data);
        }

        return redirect('osce/penjadwalan');

    }

    public function editMapping($id)
    {

        $ujian = UjianOsce::with('stationOsce.pesertaOsce')->find($id);

        if(! $ujian) {
            return redirect('osce/penjadwalan');
        }

        $station_id = StationOsce::where("id_ujian_osce", $id)->pluck('id')->toArray();

        $list_peserta = PesertaOsce::whereIn('id_station', $station_id)->where('rotasi', 1)->get();
        $list_mahasiswa = Mahasiswa::all();

        return view('master.osce.penjadwalan.mapping.edit', [
            'ujian' => $ujian,
            'list_peserta' => $list_peserta,
            'list_mahasiswa' => $list_mahasiswa
        ]);

    }

    public function updateMapping($id, Request $request)
    {

        $ujian = UjianOsce::find($id);

        if(! $ujian) {
            return redirect('osce/penjadwalan');
        }

        $station_id = StationOsce::where("id_ujian_osce", $id)->pluck('id')->toArray();

        PesertaOsce::whereIn("id_station", $station_id)->delete();

        $stations = $request->station_id;
        $mahasiswas = $request->mahasiswa_id;
        $count = count($stations);

        foreach ($mahasiswas as $mIndex => $mahasiswaId) {

            $data = [];

            for ($rotasi = 1; $rotasi <= $count; $rotasi++) {

                $stationIndex = ($mIndex + $rotasi - 1) % $count;

                $data[] = [
                    'id_station'   => $stations[$stationIndex],
                    'id_mahasiswa' => $mahasiswaId,
                    'rotasi'       => $rotasi,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ];
            }

            DB::connection('osce')->table('peserta_osce')->insert($data);
        }

        return redirect('osce/penjadwalan');
    }

    public function deleteMapping($id)
    {

        $ujian = UjianOsce::find($id);

        if(! $ujian) {
            return redirect('osce/penjadwalan');
        }

        $station_id = StationOsce::where("id_ujian_osce", $id)->pluck('id')->toArray();

        PesertaOsce::whereIn("id_station", $station_id)->delete();

        return redirect('osce/penjadwalan');
    }

    public function importDataMahasiswa(Request $request)
    {

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
