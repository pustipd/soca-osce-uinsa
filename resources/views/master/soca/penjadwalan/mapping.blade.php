@extends('layout.master')

@section('content')

    <style>
        .child-row {
            padding: 15px;
            border: 1px solid #e4e6f1;
            border-radius: 8px;
            margin-bottom: 12px;
            background: #f9fafb;
        }

    </style>

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">CRUD-MASTER</a></li>
            <li class="breadcrumb-item active" aria-current="page">ujian</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Mapping Ujian</h6>

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

                    <h4>{{$penguji->ujianSoca->nama}} Sesi {{$penguji->ujianSoca->sesi}}</h4>
                    <hr>

                    <form method="POST" action="{{ url('/soca/penjadwalan/mapping') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="id_penguji" value="{{$penguji->id}}">

                        <div class="mb-3 {{ $errors->has('penguji1') ? 'has-error' : ''}}">
                            <label for="penguji1" class="form-label">{{ 'Penguji 1' }}</label>
                            <input type="text" id="penguji1" name="penguji1" class="form-control" value="{{isset($penguji) ? $penguji->penguji1->nama : ''}}" readonly>
                            {!! $errors->first('penguji1', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="mb-3 {{ $errors->has('penguji2') ? 'has-error' : ''}}">
                            <label for="penguji2" class="form-label">{{ 'Penguji 2' }}</label>
                            <input type="text" id="penguji2" name="penguji2" class="form-control" value="{{isset($penguji) ? $penguji->penguji2->nama : ''}}" readonly>
                            {!! $errors->first('penguji2', '<p class="text-danger">:message</p>') !!}
                        </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Mahasiswa</h5>
                                <button type="button" id="addChild" class="btn btn-primary btn-sm">
                                + Tambah Mahasiswa
                                </button>
                            </div>

                            <div id="childRows">

                                @foreach ($list_peserta as $item)
                                    <div class="child-row">
                                        <div class="form-group row mb-2">
                                            <label class="col-sm-3 col-form-label">Mahasiswa</label>
                                            <div class="col-sm-7">
                                                <select name="mahasiswa[]" class="form-select">
                                                    <option value="" disabled selected>Pilih Mahasiswa</option>
                                                    @foreach ($list_mahasiswa as $mahasiswa)
                                                        <option value="{{$mahasiswa->id}}" @if ($mahasiswa->id == $item->id_mahasiswa) selected @endif>{{$mahasiswa->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2 text-right">
                                                <button type="button" class="btn btn-danger btn-sm removeChild">X</button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Urutan</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" name="urutan[]" value="{{$item->urutan}}" required>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <hr>
                        <div class="d-flex justify-content-between">
                            <a href="{{url('/soca/penjadwalan')}}" class="btn btn-secondary" >Cancel
                            </a>
                            <input  type="submit" class="btn btn-primary me-2" value="Mapping">
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
        // $('#mbkm_place_id').select2();
    </script>
    <script>
        const childContainer = document.getElementById('childRows');
        const addBtn = document.getElementById('addChild');

        function attachDeleteEvents() {
            const removeButtons = document.querySelectorAll('.removeChild');
            removeButtons.forEach(btn => {
                btn.onclick = () => btn.closest('.child-row').remove();
            });
        }

            // Call it on page load
        attachDeleteEvents();

        addBtn.addEventListener('click', () => {

            let list_option = "";
            let list_mahasiswa = @json($list_mahasiswa);

            for(let i = 0; i < list_mahasiswa.length; i++) {
                list_option += `<option value='${list_mahasiswa[i]['id']}'>${list_mahasiswa[i]['nama']}</option>`
            }

            const index = document.querySelectorAll('.child-row').length;

            const row = document.createElement('div');
            row.classList.add('child-row');

            row.innerHTML = `
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label">Mahasiswa</label>
                    <div class="col-sm-7">
                        <select name="mahasiswa[]" class="form-select">
                            <option value="" disabled selected>Pilih Mahasiswa</option>
                            ${list_option}
                        </select>
                    </div>
                    <div class="col-sm-2 text-right">
                        <button type="button" class="btn btn-danger btn-sm removeChild">X</button>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Urutan</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="urutan[]" required>
                    </div>
                </div>`;

            childContainer.appendChild(row);

            attachDeleteEvents();
        });
        </script>

@endpush
