<?php

namespace App\Http\Controllers\Osce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\StationOsce;
use App\Models\Penguji;
use App\Models\UjianOsce;

class StationController extends Controller
{
    public function index()
    {
        $stations = StationOsce::all();

        return view('master.osce.station.index', [
            'stations' => $stations
        ]);
    }

    public function create()
    {

        $list_penguji = Penguji::all();
        $list_ujian = UjianOsce::all();

        return view('master.osce.station.create', [
            "list_penguji" => $list_penguji,
            "list_ujian" => $list_ujian
        ]);
    }

    public function store(Request $request)
    {
        $station = new StationOsce();
        $station->no_station = $request->no_station;

        if($request->penguji) {
            $station->id_penguji = $request->penguji;
        }

        if($request->ujian) {
            $station->id_ujian_osce = $request->ujian;
        }

        $station->save();

        return redirect('osce/station');
    }

    public function edit($id)
    {
        $station = StationOsce::find($id);

        if(! $station)
        {
            return redirect('osce/station');
        }

        $list_penguji = Penguji::all();
        $list_ujian = UjianOsce::all();

        return view('master.osce.station.edit', [
            "list_penguji" => $list_penguji,
            "list_ujian" => $list_ujian,
            "station" => $station
        ]);
    }

    public function update($id, Request $request)
    {
        $station = StationOsce::find($id);

        if(! $station)
        {
            return redirect('osce/station');
        }

        $station->no_station = $request->no_station;
        $station->id_penguji = $request->penguji;
        $station->id_ujian_osce = $request->ujian;
        $station->save();

        return redirect('osce/station');

    }

    public function delete($id)
    {
        $station = StationOsce::find($id);

        if(! $station)
        {
            return redirect('osce/station');
        }

        if($station->pesertaOsce()->exists()){
            return redirect('osce/station');
        }

        $station->delete();
        return redirect('osce/station');

    }
}
