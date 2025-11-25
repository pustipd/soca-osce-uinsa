@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
        </ol>
    </nav>

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
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="card-title">Jadwalkan Ujian</h6>
                        <a href="{{ url('osce/exam-scheduling/create') }}">
                            <button class="btn btn-secondary">Create New</button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                                    {{-- <th scope="col" class="px-6 py-3">Station</th> --}}
                                    <th scope="col" class="px-6 py-3">Ujian</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_peserta as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $item->first()->mahasiswa()->first()->nama }}</td>
                                        {{-- <td class="px-6 py-4">{{ $item->stationOsce->no_station }}</td> --}}
                                        <td class="px-6 py-4">{{ $item->first()->stationOsce->ujianOsce->nama }}</td>
                                        <td>
                                            <a href="{{ url('/osce/exam-scheduled/' . $item->first()->id) }}" title="View Ujian"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/osce/exam-scheduled/' . $item->first()->id . '/edit') }}" title="Edit Ujian"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/osce/exam-scheduled' . '/' . $item->first()->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Ujian" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
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
