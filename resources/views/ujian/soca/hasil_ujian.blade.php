@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item active" aria-current="page">hasil</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Hasil Ujian</h6>

                   @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-alert-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            Data belum disimpan, mohon periksa kolom input anda.
                        </div>
                    @endif
                    @if (session('page_error'))
                        <div class="alert alert-danger" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-alert-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ session('page_error') }}
                        </div>
                    @endif
                    @if (session('page_success'))
                        <div class="alert alert-success" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-alert-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ session('page_success') }}
                        </div>
                    @endif

                    {{-- <form method="POST" action="{{ url('/kriteria/store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }} --}}

                        <div class="mb-3">
                            <label for="nama" class="form-label">{{ 'Nama' }}</label>
                            <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($peserta->mahasiswa->nama) ? $peserta->mahasiswa->nama : ''}}" disabled>
                            {{-- {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!} --}}
                        </div>
                        <div class="mb-3">
                            <label for="ujian" class="form-label">{{ 'Ujian' }}</label>
                            <input class="form-control" name="ujian" type="text" id="ujian" value="{{ isset($peserta->ujianSoca->nama) ? $peserta->ujianSoca->nama : ''}}" disabled>
                            {{-- {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!} --}}
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ 'Status' }}</label>
                            <input class="form-control" name="status" type="text" id="status" value="{{ isset($peserta->status) ? ucfirst($peserta->status) : ''}}" disabled>
                            {{-- {!! $errors->first('status', '<p class="text-danger">:message</p>') !!} --}}
                        </div>
                        <div class="mb-3">
                            <label for="batasnilai" class="form-label">{{ 'Batas Nilai' }}</label>
                            <input class="form-control" name="batasnilai" type="text" id="batasnilai" value="{{ isset($peserta->ujianSoca->batasnilai) ? ucfirst($peserta->ujianSoca->batasnilai) : ''}}" disabled>
                            {{-- {!! $errors->first('status', '<p class="text-danger">:message</p>') !!} --}}
                        </div>

                        <hr>

                        @foreach ($peserta->hasilUjianSoca as $key => $item)
                            <form action="{{url('/soca/penguji/update-hasil-ujian')}}" method="POST">
                            @csrf
                                <input type="hidden" name="id_ujian" value="{{$item->id}}">

                                <h3 class="mt-3 mb-2">Indikator {{$key + 1 }}</h3>

                                <div class="mb-3">
                                    <label for="skor1" class="form-label">{{ 'Skor 1' }}</label>
                                    <input class="form-control" name="skor1" type="number" id="skor1" value="{{ isset($item->skor1) ? $item->skor1 : ''}}" @if (auth('penguji')->user()->id != $peserta->id_penguji1) disabled @endif>
                                    {{-- {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!} --}}
                                </div>

                                <div class="mb-3">
                                    <label for="skor2" class="form-label">{{ 'Skor 2' }}</label>
                                    <input class="form-control" name="skor2" type="number" id="skor2" value="{{ isset($item->skor2) ? $item->skor2 : ''}}" @if (auth('penguji')->user()->id != $peserta->id_penguji2) disabled @endif>
                                    {{-- {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!} --}}
                                </div>

                                <hr>
                                <button class="btn btn-primary btn-sm w-100">Edit</button>
                            </form>
                        @endforeach


                        {{-- <div class="d-flex justify-content-between">
                            <a href="#">
                                <button class="btn btn-secondary">Cancel</button>
                            </a>
                            <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
                        </div> --}}


                    {{-- </form> --}}

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
        // $('#mbkm_place_id').select2();
    </script>
@endpush
