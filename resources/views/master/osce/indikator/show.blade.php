@extends('layout.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Indikator {{ $indikator->id }}</h6>
                        <a href="{{ url('/indikator') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/indikator/' . $indikator->id . '/edit') }}" title="Edit Indikator"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('indikator' . '/' . $indikator->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Indikator" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $indikator->id }}</td>
                                    </tr>
                                    <tr><td class="border px-8 py-4 font-bold"> Id Kriteria </td><td class="border px-8 py-4"> {{ $indikator->id_kriteria }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Deskripsi </td><td class="border px-8 py-4"> {{ $indikator->deskripsi }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Skormax </td><td class="border px-8 py-4"> {{ $indikator->skormax }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
