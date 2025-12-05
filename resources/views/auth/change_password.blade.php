@extends('layout.master')

@section('content')
    <style>
        .ck-editor__editable {
            min-height: 300px !important;
        }
    </style>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Ubah Password</h6>

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

                    <form method="POST" action="{{ url('master/penguji/ubah-password') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="mb-3 {{ $errors->has('password_saat_ini') ? 'has-error' : '' }}">
                            <label for="password_saat_ini" class="form-label">{{ 'Password Saat Ini' }}</label>
                            <input class="form-control" name="password_saat_ini" type="text" id="password_saat_ini">
                            {!! $errors->first('password_saat_ini', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="mb-3 {{ $errors->has('password_baru') ? 'has-error' : '' }}">
                            <label for="password_baru" class="form-label">{{ 'Password Baru' }}</label>
                            <input class="form-control" name="password_baru" type="text" id="password_baru">
                            {!! $errors->first('password_baru', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="mb-3 {{ $errors->has('password_konfirmasi') ? 'has-error' : '' }}">
                            <label for="password_konfirmasi" class="form-label">{{ 'Password Konfirmasi' }}</label>
                            <input class="form-control" name="password_konfirmasi" type="text" id="password_konfirmasi">
                            {!! $errors->first('password_konfirmasi', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" onclick="window.location='{{ url()->previous() }}'" class="btn btn-secondary">Cancel
                            </button>
                            <input type="submit" class="btn btn-primary me-2"
                                value="Ubah">
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
@endpush
