@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')

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

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col" class="px-6 py-3">Station</th>
                                    <th scope="col" class="px-6 py-3">Ujian</th>
                                    <th scope="col" class="px-6 py-3">Kriteria</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Mahasiswa</th>
                                    <th scope="col" class="px-6 py-3">Jumlah Mahasiswa Belum Dinilai</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_station as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $item->no_station }}</td>
                                        <td class="px-6 py-4">{{ $item->ujianOsce->nama }} Sesi {{ $item->ujianOsce->sesi }}</td>
                                        <td class="px-6 py-4">{{ $item->kriteriaOsce->nama }}</td>
                                        <td class="px-6 py-4">{{ $item->pesertaOsce->count() }}</td>
                                        <td class="px-6 py-4">{{ $item->peserta_ongoing_count }}</td>
                                        <td>
                                            @if ($item->status == "selesai")
                                                <a href="{{ url('/osce/penguji/hasil-ujian/' . $item->id) }}" title="View Ujian">
                                                    <button class="btn btn-secondary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Lihat hasil</button>
                                                </a>
                                            @else
                                                <a href="{{ url('/osce/penguji/ujian/' . $item->id) }}" title="View Ujian">
                                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>Mulai Ujian</button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
