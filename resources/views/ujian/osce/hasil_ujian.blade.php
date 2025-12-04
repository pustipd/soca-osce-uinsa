@extends('layout.master')

@section('content')

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

                    <form method="POST" action="{{ url('/kriteria/store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label for="nama" class="form-label">{{ 'Nama' }}</label>
                            <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($peserta->mahasiswa->nama) ? $peserta->mahasiswa->nama : ''}}" disabled>
                            {{-- {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!} --}}
                        </div>
                        {{-- <div class="mb-3">
                            <label for="ujian" class="form-label">{{ 'Ujian' }}</label>
                            <input class="form-control" name="ujian" type="text" id="ujian" value="{{ isset($peserta->ujianSoca->nama) ? $peserta->ujianSoca->nama : ''}}" disabled>
                            {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!}
                        </div> --}}

                        <hr>

                        @foreach ($peserta->hasilUjianOsce as $key => $item)

                            <h3>Indikator {{$key + 1}}</h3>

                            <div class="mb-3">
                                <label for="skor" class="form-label">{{ 'Skor' }}</label>
                                <input class="form-control" name="skor" type="text" id="skor" value="{{ isset($item->skor) ? $item->skor : ''}}" disabled>
                                {{-- {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!} --}}
                            </div>

                            <div class="mb-3">
                                <label for="bobot" class="form-label">{{ 'Bobot' }}</label>
                                <input class="form-control" name="bobot" type="text" id="bobot" value="{{ isset($item->bobot) ? $item->bobot : ''}}" disabled>
                                {{-- {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!} --}}
                            </div>

                            <hr>

                        @endforeach

                        {{-- <div class="d-flex justify-content-between">
                            <a href="#">
                                <button class="btn btn-secondary">Cancel</button>
                            </a>
                            <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
                        </div> --}}


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
        // $('#mbkm_place_id').select2();
    </script>
@endpush
