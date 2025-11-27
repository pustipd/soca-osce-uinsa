<?php

namespace App\Http\Controllers\Soca;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\KategoriSoca;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriSoca::all();

        return view('master.soca.kategori.index', [
            "kategorisoca" => $kategori
        ]);
    }

    public function create()
    {
        return view('master.soca.kategori.create');
    }

    public function store(Request $request)
    {
        $kategori = new KategoriSoca();
        $kategori->nama = $request->nama;
        $kategori->save();

        return redirect('soca/kategori');
    }

    public function edit($id, Request $request)
    {
        $kategori = KategoriSoca::find($id);

        if(! $kategori) {
            return redirect('soca/kategori');
        }

        return view("master.soca.kategori.edit", [
            "kategorisoca" => $kategori
        ]);
    }

    public function update($id, Request $request)
    {

        $kategori = KategoriSoca::find($id);

        if(! $kategori) {
            return redirect('soca/kategori');
        }

        $kategori->nama = $request->nama;
        $kategori->save();

        return redirect('soca/kategori');
    }

    public function delete($id)
    {

        $kategori = KategoriSoca::find($id);

        if(! $kategori) {
            return redirect('soca/kategori');
        }

        if($kategori->indikatorSoca()->exists()) {
            return redirect('soca/kategori');
        }

        $kategori->delete();

        return redirect('soca/kategori');
    }
}
