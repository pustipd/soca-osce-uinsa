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
                        <h6 class="card-title">Ujian</h6>
                        <a href="{{ url('/soca/ujian/create') }}">
                            <button class="btn btn-secondary">Create New</button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">Sesi</th>
                                    <th scope="col" class="px-6 py-3">Waktu</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ujian as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $item->nama }}</td><td class="px-6 py-4">{{ $item->sesi }}</td><td class="px-6 py-4">{{ $item->waktu }}</td>

                                        <td class="px-6 py-4">
                                            @if ($item->status == 1)
                                                <div class="d-flex">
                                                    <p class="me-3">Aktif</p>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch mb-2">
                                                            <input type="checkbox" class="form-check-input switch-aktif" id="switch-aktif" data-id="{{$item->id}}" @if ($item->status == 1) checked @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex">
                                                    <p class="me-3">Tidak Aktif</p>
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch mb-2">
                                                            <input type="checkbox" class="form-check-input switch-nonaktif" id="switch-nonaktif" data-id="{{$item->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="{{ url('/soca/penjadwalan/mapping/' . $item->id) }}" title="Mapping Ujian"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Mapping</button></a> --}}
                                            <a href="{{ url('/soca/penjadwalan/create/') . '?ujian_id=' . $item->id }}" title="Mapping Ujian"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Mapping</button></a>
                                            <a href="{{ url('/soca/ujian/' . $item->id . '/edit') }}" title="Edit Ujian"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/soca/ujian' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
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
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>

        $(".switch-aktif").on("change", function() {

            let checkbox = $(this);
            let currentState = checkbox.prop("checked");

            let url = "{{url('soca/ujian/change-status')}}" + "/" + $(this).data("id");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin mengganti status ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'me-2',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: url,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("SUCCESS:", response);

                            if(response.status == 'success') {

                            } else {
                                checkbox.prop("checked", !currentState)
                            }

                        },
                        error: function(xhr) {
                            checkbox.prop("checked", !currentState)
                            console.log("ERROR:", xhr.responseText);
                        }
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                    checkbox.prop("checked", !currentState)
                    return;
                }
            })

        });

        $(".switch-nonaktif").on("change", function() {

            let checkbox = $(this);
            let currentState = checkbox.prop("checked");

            let url = "{{url('soca/ujian/change-status')}}" + "/" + $(this).data("id");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin mengganti status ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'me-2',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.value) {

                    $.ajax({
                        url: url,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("SUCCESS:", response);

                            if(response.status == 'success') {

                            } else {

                                checkbox.prop("checked", !currentState)
                            }

                        },
                        error: function(xhr) {
                            console.log("ERROR:", xhr.responseText);
                        }
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )

                    checkbox.prop("checked", !currentState)
                    return;
                }
            })

        });

    </script>
@endpush
