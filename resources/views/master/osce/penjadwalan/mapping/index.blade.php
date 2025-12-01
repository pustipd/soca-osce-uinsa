@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Penjadwalan Ujian</h6>
                        <a href="{{ url('osce/penjadwalan') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    </div>

                    <form method="POST" action="{{ url('osce/penjadwalan/mapping') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="ujian_id" value="{{$ujian->id}}">

                        <div class="mb-3">
                            <label for="" class="form-label">Nama Ujian</label>
                            <input type="text" class="form-control" value="{{$ujian->nama}} Sesi {{$ujian->sesi}}" readonly>
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

                        <p style="font-size: 12px; font-weight: 700" class="mb-2">Note : rotasi 2, 3, dst akan otomatis terinput oleh sistem</p>

                        {{-- <button id="btn-tambah-rotasi" type="button" class="btn btn-primary btn-sm mb-3">Tambah Rotasi</button> --}}

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>Rotasi</th>
                                    <th>Penguji</th>
                                    <th>Mahasiswa</th>
                                </tr>
                            </thead>

                            @php($rotasi = 1)

                            <tbody id="body-table">
                                @foreach ($ujian->stationOsce as $key => $item)
                                    <input type="hidden" name="station_id[]" value="{{$item->id}}">
                                    <tr>
                                        <td>{{$item->no_station}}</td>
                                        <td>{{$rotasi}}</td>
                                        <td>{{($item->penguji()->exists()) ? $item->penguji->nama : '--- Istirahat ---'}}</td>
                                        <td>
                                            <select name="mahasiswa_id[]" class="form-select">
                                                <option value="" selected disabled>Pilih Mahasiswa</option>
                                                @foreach ($list_mahasiswa as $mahasiswa)
                                                    <option value="{{$mahasiswa->id}}">{{$mahasiswa->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>

                        </table>


                        {{-- <div class="mb-3 {{ $errors->has('id_mahasiswa') ? 'has-error' : '' }}">
                            <label for="id-mahasiswa" class="form-label">{{ 'Nama Mahasiswa' }}</label>
                            <select name="id_mahasiswa" id="id-mahasiswa" class="form-select select2">
                                <option value="" disabled selected>Pilih Mahasiswa</option>
                                @foreach ($list_mahasiswa as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}" @if (isset($peserta) && $peserta->id_mahasiswa == $mahasiswa->id) selected @endif>
                                        {{ $mahasiswa->nama }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('id_mahasiswa', '<p class="text-danger">:message</p>') !!}
                        </div> --}}

                        {{-- <div class="mb-3 {{ $errors->has('id-ujian') ? 'has-error' : '' }}">
                            <label for="id-ujian" class="form-label">{{ 'Ujian' }}</label>
                            <select name="id_ujian" id="id-ujian" class="form-select select2">
                                <option value="" disabled selected>Pilih Ujian</option>
                                @foreach ($list_ujian as $ujian)
                                    <option value="{{ $ujian->id }}" @if (isset($peserta) && $id_ujian == $ujian->id) selected @endif>
                                        {{ $ujian->nama }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('id_ujian', '<p class="text-danger">:message</p>') !!}
                        </div> --}}

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{url('osce/penjadwalan')}}" class="btn btn-secondary">Cancel
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
        $("#id-ujian").select2();
    </script>

    <script>
        $(document).ready(function() {

            let list_station = @json($ujian->stationOsce);

            function refreshTable(data) {

                let tbody = $("#body-table");
                tbody.html(""); // reset

                let row = '';

                list_station.forEach((item, index) => {

                    row += `
                        <tr>
                            <td>${item.no_station}</td>
                            <td>1</td>
                            <td>${item.penguji ? item.penguji.nama : '--- Istirahat ---'}</td>
                            <td>
                                <input type="hidden" name="station_id[]" value="${item.id}">
                                <input type="hidden" name="mahasiswa_id[]" class="form-control" value="${data[index].id}" >
                                <input type="text" class="form-control" value="${data[index].nama}" readonly>
                            </td>
                        </tr>
                    `;

                });

                tbody.append(row);
            }

            $("#btn-import").on("click", function() {

                let fd = new FormData();
                fd.append("import_mahasiswa", $("input[name=import_mahasiswa]")[0].files[0]);

                $.ajax({
                    url: "{{url('/osce/penjadwalan/mapping/import')}}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response.data.length + ' x ' + list_station.length);
                        if(response.data.length != list_station.length) {
                            // data import tidak sama dengan station
                        } else {
                            // success
                            refreshTable(response.data)

                        }
                        // childContainer.innerHTML = "";
                        // response.data.forEach((item, index) => {
                        //     addChildRowFromImport(item, index + 1);
                        // });

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
@endpush
