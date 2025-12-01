@extends('layout.master')

@section('content')
    {{-- <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item"><a href="{{ url('osce/exam-scheduled') }}">ujian</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $ujian->id }}</li>
        </ol>
    </nav> --}}

    <div class="container">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Detail</h6>
                        <a href="{{ url('/osce/penjadwalan') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        {{-- <a href="{{ url('/ujian/' . 1 . '/edit') }}" title="Edit Ujian"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> --}}

                        <form method="POST" action="{{ url('ujian' . '/' . 1) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Ujian" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>MAHASISWA</th>
                                        <td>{{ $list_peserta->first()->mahasiswa->nama }}</td>
                                    </tr>

                                    @foreach ($list_peserta as $item)
                                        <tr>
                                            <td class="border px-8 py-4 font-bold"> Station </td>
                                            <td class="border px-8 py-4"> {{$item->stationOsce->no_station}} </td>
                                        </tr>

                                        <tr>
                                            <td class="border px-8 py-4 font-bold"> Penguji </td>
                                            <td class="border px-8 py-4"> {{ $item->stationOsce->penguji()->exists() ? $item->stationOsce->penguji->nama : '-' }} </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
