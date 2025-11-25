@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                         <h6 class="card-title">Penjadwalan Ujian</h6>
                        <a href="{{ url('osce/exam-scheduled') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    </div>

                    <form method="POST" action="{{url('osce/exam-scheduling/store')}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('master.osce.ujian.form_penjadwalan', ['formMode' => 'create'])

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
        $("#id-ujian").select2();
    </script>
@endpush
