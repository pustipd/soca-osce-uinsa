@extends('layout.master')

@section('content')

    <style>
        .ck-editor__editable {
            min-height: 300px !important;
        }
    </style>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item active" aria-current="page">indikator</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create New Indikator</h6>

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

                    <form method="POST" action="{{ url('/soca/indikator/store') }}" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('master.soca.indikator.form', ['formMode' => 'create'])

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
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
@endpush

@push('custom-scripts')
    <script>
        $('#id_kriteria').select2();
        $('#id_kategori').select2();
    </script>

    <script>
        $("#input-form-dokumen").css('display', 'none');
        $("input[name='jenis_indikator']").on("change", function() {

            if($(this).val() == "deskripsi") {
                $("#input-form-deskripsi").show();
                $("#input-form-dokumen").hide();
            } else {
                $("#input-form-deskripsi").hide();
                $("#input-form-dokumen").show();
            }

        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .then(editor => {
                console.log("CKEditor ready");
            })
            .catch(error => {
                console.error(error);
            });
    </script>


@endpush
