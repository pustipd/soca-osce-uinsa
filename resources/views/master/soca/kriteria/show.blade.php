@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/kriteria') }}">kriteria</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kriteria->id }}</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Kriteria {{ $kriteria->id }}</h6>
                        <a href="{{ url('/kriteria') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/kriteria/' . $kriteria->id . '/edit') }}" title="Edit Kriteria"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('kriteria' . '/' . $kriteria->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Kriteria" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $kriteria->id }}</td>
                                    </tr>
                                    <tr><td class="border px-8 py-4 font-bold"> Nama </td><td class="border px-8 py-4"> {{ $kriteria->nama }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Totalnilai </td><td class="border px-8 py-4"> {{ $kriteria->totalnilai }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
