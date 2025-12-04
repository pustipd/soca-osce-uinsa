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

                        <h5 class="mb-3">Metode Input Data Mahasiswa</h5>

                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="input_mahasiswa" id="manual-input" value="manual" checked>
                                <label class="form-check-label" for="manual-input">
                                    Input Manual Data Mahasiswa
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="input_mahasiswa" id="import-mahasiswa" value="import">
                                <label class="form-check-label" for="import-mahasiswa">
                                    Import Data Mahasiswa
                                </label>
                            </div>
                        </div>

                        <div id="form-import-mahasiswa" class="mb-2" style="display: none">
                            {{-- <form id="form-tt" action="{{url('/soca/penjadwalan/mapping/import')}}" method="POST" enctype="multipart/form-data"> --}}
                                {{-- @csrf --}}
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <label for="form-label">Impor Data Mahasiswa</label>
                                        <input type="file" name="import_mahasiswa" class="form-control">
                                    </div>
                                    <button id="btn-import" type="button" class="btn btn-primary btn-sm">Import</button>
                                </div>
                            {{-- </form> --}}
                        </div>

                        <div id="form-input-manual-mahasiswa" style="display: flex" class="justify-content-between align-items-center mb-2">
                            <h5>Mahasiswa</h5>
                            <button type="button" id="addChild" class="btn btn-primary btn-sm">
                            + Tambah Mahasiswa
                            </button>
                        </div>

                        <div id="childRows" class="mt-2">

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

        let list_mahasiswa = @json($list_mahasiswa);

        function addChildRowFromImport(item, index) {

            const childContainer = document.getElementById('childRows');

            const row = document.createElement('div');
            row.classList.add('child-row');

            row.innerHTML = `
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label">Mahasiswa</label>
                    <div class="col-sm-7">
                        <input type="hidden" class="form-control" name="mahasiswa[]" value="${item.id}">
                        <input type="text" class="form-control" value="${item.nama}" readonly>
                    </div>
                    <div class="col-sm-2 text-right">
                        <button type="button" class="btn btn-danger btn-sm removeChild">X</button>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Urutan</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="urutan[]" required value="${index ?? ''}" readonly>
                    </div>
                </div>
            `;

            childContainer.appendChild(row);

            // Populate select mahasiswa

            attachDeleteEvents();
        }

        $(document).ready(function() {

            $("#btn-import").on("click", function() {

                let fd = new FormData();
                fd.append("import_mahasiswa", $("input[name=import_mahasiswa]")[0].files[0]);

                $.ajax({
                    url: "{{url('/soca/penjadwalan/mapping/import')}}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        console.log(response);
                        childContainer.innerHTML = "";
                        response.data.forEach((item, index) => {
                            addChildRowFromImport(item, index + 1);
                        });

                    },
                    error: function(response) {
                        console.error(response)
                    }
                });

            });

            $("input[name='input_mahasiswa']").on('change', function() {
                let metode = $(this).val();

                if(metode == 'import') {
                    $('#form-import-mahasiswa').css('display', 'block');
                    $('#form-input-manual-mahasiswa').css('display', 'none');
                } else {
                    $('#form-input-manual-mahasiswa').css('display', 'flex');
                    $('#form-import-mahasiswa').css('display', 'none');
                }

            });

        });
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
