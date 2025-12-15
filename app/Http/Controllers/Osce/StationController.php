<?php

namespace App\Http\Controllers\Osce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// Models
use App\Models\StationOsce;
use App\Models\Penguji;
use App\Models\UjianOsce;
use App\Models\KriteriaOsce;

class StationController extends Controller
{
    public function index($ujian_id)
    {
        $ujian = UjianOsce::find($ujian_id);

        if(! $ujian) {
            Session::flash("page_error", "Data ujian tidak ditemukan");
            return redirect()->back();
        }

        $stations = StationOsce::where("id_ujian_osce", $ujian_id)->get();

        return view('master.osce.station.index', [
            'stations' => $stations,
            "ujian" => $ujian
        ]);
    }

    public function create($ujian_id)
    {
        $ujian = UjianOsce::find($ujian_id);

        if(! $ujian) {
            Session::flash("page_error", "Data ujian tidak ditemukan");
            return redirect()->back();
        }

        $list_penguji = Penguji::all();
        $list_ujian = UjianOsce::all();
        $list_kriteria = KriteriaOsce::all();

        return view('master.osce.station.create', [
            "list_penguji" => $list_penguji,
            "list_ujian" => $list_ujian,
            'list_kriteria' => $list_kriteria,
            "ujian" => $ujian
        ]);
    }

    public function store(Request $request)
    {

        $station = StationOsce::where("id_ujian_osce", $request->ujian)->where("no_station", $request->no_station)->first();

        if($station) {
            Session::flash("page_error", "Station sudah ada");
            return redirect('osce/ujian/station/' . $request->ujian);
        }

        $station = new StationOsce();
        $station->no_station = $request->no_station;

        if($request->penguji) {
            $station->id_penguji = $request->penguji;
        }

        if($request->ujian) {
            $station->id_ujian_osce = $request->ujian;
        }

        if($request->kriteria) {
            $station->id_kriteria = $request->kriteria;
        }

        $station->save();

        Session::flash("page_success", "Berhasil tambah data station");
        return redirect('osce/ujian/station/' . $request->ujian);
    }

    public function edit($ujian_id, $id)
    {
        $ujian = UjianOsce::find($ujian_id);

        if(! $ujian) {
            Session::flash("page_error", "Data ujian tidak ditemukan");
            return redirect()->back();
        }

        $station = StationOsce::find($id);

        if(! $station)
        {
            Session::flash("page_error", "Data station tidak ditemukan");
            return redirect('osce/ujian/station' . "/" . $ujian_id);
        }

        $list_penguji = Penguji::all();
        $list_ujian = UjianOsce::all();
        $list_kriteria = KriteriaOsce::all();

        return view('master.osce.station.edit', [
            "list_penguji" => $list_penguji,
            "list_ujian" => $list_ujian,
            "station" => $station,
            'list_kriteria' => $list_kriteria,
            "ujian" => $ujian
        ]);
    }

    public function update($ujian_id, $id, Request $request)
    {

        $ujian = UjianOsce::find($ujian_id);

        if(! $ujian) {
            Session::flash("page_error", "Data ujian tidak ditemukan");
            return redirect()->back();
        }

        $station = StationOsce::find($id);

        if(! $station)
        {
            Session::flash("page_error", "Data station tidak ditemukan");
            return redirect('osce/ujian/station/' . $ujian_id);
        }

        $exists = StationOsce::where('id', '!=', $id)->where("no_station", $request->no_station)->where("id_ujian_osce", $request->ujian)->first();

        if($exists) {
            Session::flash("page_error", "Nomor station sudah ada");
            return redirect('osce/ujian/station/' . $ujian_id);
        }

        $station->no_station = $request->no_station;
        $station->id_penguji = $request->penguji;
        $station->id_ujian_osce = $request->ujian;
        if($request->kriteria) {
            $station->id_kriteria = $request->kriteria;
        }
        $station->save();

        Session::flash("page_success", "Berhasil update data station");
        return redirect('osce/ujian/station/' . $request->ujian);

    }

    public function delete($ujian_id, $id)
    {
        $ujian = UjianOsce::find($ujian_id);

        if(! $ujian) {
            Session::flash("page_error", "Data ujian tidak ditemukan");
            return redirect()->back();
        }

        $station = StationOsce::find($id);

        if(! $station)
        {
            Session::flash("page_error", "Data station tidak ditemukan");
            return redirect('osce/ujian/station/' . $ujian_id);
        }

        if($station->pesertaOsce()->exists()){
            Session::flash("page_error", "Gagal hapus data, station sudah dimappingkan dengan peserta");
            return redirect('osce/ujian/station/' . $ujian_id);
        }

        $station->delete();
        Session::flash("page_success", "Berhasil hapus data");
        return redirect('osce/ujian/station/' . $ujian_id);

    }
}
