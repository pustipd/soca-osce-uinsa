@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                         <h6 class="card-title">Penjadwalan Ujian</h6>
                        <a href="{{ url('osce/exam-scheduling') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    </div>

                    <form method="POST" action="{{url('osce/exam-scheduling/store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="mb-3 {{ $errors->has('id_mahasiswa') ? 'has-error' : ''}}">
                            <label for="id-mahasiswa" class="form-label">{{ 'Nama Mahasiswa' }}</label>
                            <select name="id_mahasiswa" id="id-mahasiswa" class="form-select select2">
                                <option selected>Pilih Mahasiswa</option>
                                @foreach ($list_mahasiswa as $mahasiswa)
                                    <option value="{{$mahasiswa->id}}">{{$mahasiswa->nama}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('id_mahasiswa', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="mb-3 {{ $errors->has('id-station') ? 'has-error' : ''}}">
                            <label for="id-station" class="form-label">{{ 'Station' }}</label>
                            <select name="id_station" id="id-station" class="form-select select2">
                                <option selected>Pilih Station</option>
                                @foreach ($list_station as $station)
                                    <option value="{{$station->id}}">{{$station->no_station}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('id_station', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="#">
                                <button class="btn btn-secondary">Cancel</button>
                            </a>
                            <input type="submit" class="btn btn-primary me-2" value="Jadwalkan">
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
        $("#id-mahasiswa").select2();
        $("#id-penguji1").select2();
        $("#id-penguji2").select2();
        $("#id-ujian-soca").select2();
    </script>
@endpush
