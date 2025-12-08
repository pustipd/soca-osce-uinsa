@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <style>
        .wizard-steps-right {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .wizard-steps-right .step-item {
            padding: 12px 16px;
            border-radius: 6px;
            background: #f1f2f7;
            font-weight: 500;
            cursor: pointer;
            transition: 0.25s;
        }

        .wizard-steps-right .step-item.active {
            /* background: #6571ff; */
            background: #125335;
            /* NobleUI primary */
            color: white;
        }

        .step-content {
            display: none;
            height: 350px;
            border: 1px solid #ddd;
            /* border-radius: 6px; */
            padding: 0;
            /* remove padding so footer fits cleanly */
            /* display: flex; */
            flex-direction: column;
            /* allow scroll top + fixed bottom */
            background: #fff;
        }

        /* Active shows the container */
        .step-content.active {
            display: flex;
        }

        /* Scrollable top content */
        .step-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* Footer fixed at bottom */
        .form-footer {
            padding: 12px 20px;
            border-top: 1px solid #ddd;
            background: #fff;
            overflow: auto;
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }
    </style>

    <style>
        .indikator-box {
            height: 500px !important;
            /* or any fixed height you need */
            display: flex;
            flex-direction: column;
            position: relative !important;
            /* border: 1px solid #ccc; */
            padding: 10px !important;
            width: 100% !important;
        }

        /* Scrollable text */
        .scroll-area {
            flex: 1;
            /* take all available space except footer */
            overflow-y: auto;
            /* makes it scrollable */
            margin-bottom: 10px;
        }

        /* Footer fixed at bottom of the section */
        .footer-ujian {
            padding: 8px;
            background: #f1f1f1;
            border-top: 1px solid #ccc;
            text-align: center;
            flex-shrink: 0;
            /* prevents footer from shrinking */
        }

        .wizard.vertical>.content {
            margin-left: 0 !important;
        }

        .wizard .steps {
            float: right !important;
            /* width: 220px; */
        }

        .wizard .content {
            margin-right: 240px;
        }
    </style>

    <style>
        .radio-button-group {
            display: flex;
            gap: 8px;
        }

        .radio-button {
            position: relative;
        }

        .radio-button input {
            display: none;
        }

        .radio-button label {
            padding: 8px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f5f5f5;
            cursor: pointer;
            transition: 0.2s;
            font-weight: 500;
        }

        .radio-button input:checked+label {
            /* background: #6571ff;
            border-color: #6571ff; */
            background: #125335;
            border-color: #125335;
            color: #fff;
        }

        .step-item.done {
            border-left: 4px solid #28a745 !important;
            background: #e8f7ee;
            color: #28a745;
            font-weight: bold;
        }
    </style>

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="form-penilaian" action="{{ url('osce/penguji/penilaian-ujian') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between mb-4">
                            <h5>{{ $station->ujianOsce->nama }} Sesi {{ $station->ujianOsce->sesi }}</h5>
                            <div class="d-flex" style="gap: 16px">
                                <p class="bg-primary ps-3 pe-3 pt-1 pb-1" style="border-radius: 6px; color: white">{{$peserta->mahasiswa->nama}}</p>
                                <p>Total Nilai : <span id="total-nilai" class="badge bg-warning text-dark">0</span></p>
                            </div>
                        </div>

                        {{-- <div class="d-flex">
                        <button type="button" id="btn-check-nilai" class="btn btn-outline-primary btn-sm mb-3 me-4">Check Nilai</button>
                        <h6 style="font-size: 12px" class="mt-2">Status Nilai : <span id="status-nilai" style="color: red">Tidak Sinkron</span></h6>
                    </div> --}}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <!-- LEFT: CONTENT -->
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">

                                                {{-- <input type="hidden" name="tipe_penguji" value="{{$tipe_penguji}}"> --}}
                                                <input id="peserta-id" type="hidden" name="peserta_id" value="{{ $peserta->id }}">
                                                <input type="hidden" name="station_id" value="{{ $station->id }}">

                                                <div id="wizardContents">
                                                    @foreach ($list_indikator as $key => $indikator)
                                                        <input type="hidden" name="indikator_id[]"
                                                            value="{{ $indikator->id }}">

                                                        <div class="step-content {{ $key == 0 ? 'active' : '' }}"
                                                            data-step="{{ $key + 1 }}">

                                                            <!-- Scrollable content wrapper -->
                                                            <div class="step-scroll">

                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <h4>
                                                                        {{ $indikator->nama }}
                                                                    </h4>
                                                                    <p class="badge bg-warning text-dark">Bobot :
                                                                        {{ $indikator->bobot }}</p>
                                                                </div>
                                                                <input type="hidden" name="bobot[{{ $key }}]"
                                                                    value="{{ $indikator->bobot }}">

                                                                <div class="form-group">
                                                                    {{-- <label>{{ Str::limit($indikator->deskripsi, 10) }}</label> --}}
                                                                    @if ($indikator->jenis_indikator == 'deskripsi')
                                                                        <div class="text-block">
                                                                            {!! $indikator->deskripsi !!}
                                                                        </div>
                                                                    @else
                                                                        <div class="text-block">
                                                                            <iframe
                                                                                src="{{ Storage::url($indikator->dokumen) }}"
                                                                                width="100%" height="600px"></iframe>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Fixed footer -->
                                                            <div class="form-footer">
                                                                {{-- <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="nilai[{{$key}}]" value="0" checked>
                                                                    <label class="form-check-label">0</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="nilai[{{$key}}]" value="1" checked>
                                                                    <label class="form-check-label">1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="nilai[{{$key}}]" value="2" checked>
                                                                    <label class="form-check-label">2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="nilai[{{$key}}]" value="3" checked>
                                                                    <label class="form-check-label">3</label>
                                                                </div> --}}


                                                                <div class="radio-button-group">

                                                                    <div class="radio-button">
                                                                        <input type="radio"
                                                                            id="nilai{{ $key }}_0"
                                                                            name="nilai[{{ $key }}]"
                                                                            value="0" class="point-radio" data-step="{{ $key + 1 }}">

                                                                        <label for="nilai{{ $key }}_0">0</label>
                                                                    </div>

                                                                    <div class="radio-button">
                                                                        <input type="radio"
                                                                            id="nilai{{ $key }}_1"
                                                                            name="nilai[{{ $key }}]"
                                                                            value="1" class="point-radio" data-step="{{ $key + 1 }}">

                                                                        <label for="nilai{{ $key }}_1">1</label>
                                                                    </div>

                                                                    <div class="radio-button">
                                                                        <input type="radio"
                                                                            id="nilai{{ $key }}_2"
                                                                            name="nilai[{{ $key }}]"
                                                                            value="2" class="point-radio" data-step="{{ $key + 1 }}">

                                                                        <label for="nilai{{ $key }}_2">2</label>
                                                                    </div>

                                                                    <div class="radio-button">
                                                                        <input type="radio"
                                                                            id="nilai{{ $key }}_3"
                                                                            name="nilai[{{ $key }}]"
                                                                            value="3" class="point-radio" data-step="{{ $key + 1 }}">

                                                                        <label for="nilai{{ $key }}_3">3</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- BUTTONS OUTSIDE CONTENT -->
                                                <div class="wizard-buttons mt-3 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary" id="btnPrev"
                                                        disabled>Back</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnNext">Next</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- RIGHT: STEPPER -->
                                    <div class="col-md-4">
                                        <div class="card" style="height: 455px; overflow: auto;">
                                            <div class="card-body">
                                                <div class="wizard-steps-right">
                                                    @foreach ($list_indikator as $key => $item)
                                                        <div class="step-item {{ $key == 0 ? 'active' : '' }}"
                                                            data-step="{{ $key + 1 }}">{{ $key + 1 }}.
                                                            {{ $item->nama }}</div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card mt-3">
                                    <div class="card-title text-center mt-3">Daftar Mahasiswa</div>
                                    <div class="card-body">

                                        @foreach ($list_peserta as $item)
                                            <div
                                                class="badge {{ $item->id == $peserta->id ? 'bg-primary' : 'bg-secondary' }} w-100 p-2 mb-2">
                                                <p class="text-center">{{ $item->mahasiswa->nama }}</p>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form-label">Rating</label>
                                            <select name="rating" class="form-select">
                                                <option value="tidak lulus">Tidak Lulus</option>
                                                <option value="borderline">Borderline</option>
                                                <option value="lulus">Lulus</option>
                                                <option value="superior">Superior</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form-label">Feedback untuk mahasiswa</label>
                                            <textarea name="feedback" class="form-control" id="feedback" cols="10" rows="5"></textarea>
                                        </div>
                                        <button id="tidak-hadir" class="btn btn-danger w-100 mt-3">Tidak Hadir</button>
                                        <button id="submit-penilaian" class="btn btn-primary w-100 mt-3">Simpan
                                            Penilaian</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>

                </form>
            </div>
        </div>
    </div>
@endsection

<script></script>

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        let nilai = {};
        let total_nilai = 0;

        let currentStep = 0;
        const steps = document.querySelectorAll('.step-content');
        const stepItems = document.querySelectorAll('.step-item'); // RIGHT STEPPER ITEMS

        function showStep(index) {

            // Show only selected step
            steps.forEach((s, i) => s.classList.toggle('active', i === index));

            // Move RIGHT STEPPER
            stepItems.forEach((item, i) => item.classList.toggle('active', i === index));

            // Back button disabled on first step
            document.getElementById('btnPrev').disabled = index === 0;

            // Change Next → Submit
            if (index === steps.length - 1) {
                document.getElementById('btnNext').style.display = "none";
                document.getElementById('btnNext').innerText = "Submit";
            } else {
                document.getElementById('btnNext').style.display = "block";
                document.getElementById('btnNext').innerText = "Next";
            }
        }

        // RIGHT STEPPER CLICKABLE
        stepItems.forEach((item, index) => {
            item.addEventListener('click', () => {

                // Save current nilai before moving
                let value = document.querySelector('input[name="nilai[' + currentStep + ']"]:checked');
                if (value) {
                    nilai[currentStep] = Number(value.value);
                }

                // Move to selected step
                currentStep = index;
                showStep(currentStep);

                // Recalculate total nilai
                total_nilai = 0;
                Object.keys(nilai).forEach(key => {
                    total_nilai += Number(nilai[key]);
                });
                document.getElementById('total-nilai').innerText = total_nilai;
            });
        });

        document.getElementById('btnPrev').addEventListener('click', () => {
            // document.getElementById('btnNext').disabled = false;
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        document.getElementById('btnNext').addEventListener('click', () => {

            let current = $('.step-item.active');
            let next = current.next('.step-item');

            // tandai step sekarang jadi done
            current.removeClass('active').addClass('done');

            // aktifkan step berikutnya
            next.addClass('active');

            if (currentStep < steps.length - 1) {

                let value = document.querySelector('input[name="nilai[' + currentStep + ']"]:checked').value;
                nilai[currentStep] = Number(value);

                currentStep++;
                showStep(currentStep);
            } else {
                let value = document.querySelector('input[name="nilai[' + (Number(currentStep)) + ']"]:checked')
                    .value;
                nilai[currentStep] = Number(value);
                // document.getElementById('btnNext').disabled = true;
            }

            total_nilai = 0;
            Object.keys(nilai).forEach(key => {
                const bobot = document.querySelector('input[name="bobot[' + key + ']"]').value;
                total_nilai += Number(nilai[key] * bobot);
            });

            document.getElementById('total-nilai').innerText = total_nilai;
        });

        $('input[type=radio]').on('change', function() {

            let index = this.name.match(/\[(\d+)\]/)[1];

            nilai[index] = this.value;

            total_nilai = 0;
            Object.keys(nilai).forEach(key => {
                total_nilai += Number(nilai[key]);
            });
            document.getElementById('total-nilai').innerText = total_nilai;

        });

        // Initialize first step
        showStep(currentStep);
    </script>

    <script>

        function isAllAnswered() {
            let totalSteps = $('.step-content').length;
            let answered = 0;

            $('.step-content').each(function() {
                let step = $(this).data('step');
                let radios = $('input[name="nilai[' + (step-1) + ']"]');

                if (radios.is(':checked')) {
                    answered++;
                }
            });

            return answered === totalSteps;
        }

        $("#submit-penilaian").on("click", function(e) {
            e.preventDefault();

            if (!isAllAnswered()) {
                // e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Semua rubrik/indikator wajib diberi nilai.'
                });
                return;
            }

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak bisa kembali lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'me-2',
                confirmButtonText: 'Ya, Yakin',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    let is_complete = true;

                    let feedback = $("#feedback").val();

                    if (!feedback) {
                        is_complete = false;
                    }

                    if (is_complete) {
                        $("#form-penilaian").submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Pastikan sudah mengisi feedback',
                        })
                    }

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                }
            })

        });

        $("#tidak-hadir").on("click", function(e) {
            e.preventDefault();

            let peserta_id = $("#peserta-id").val();

            const tidakHadirSwal = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            tidakHadirSwal.fire({
                title: 'Apakah anda yakin mahasiswa tidak hadir?',
                text: "Anda tidak bisa kembali lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'me-2',
                confirmButtonText: 'Ya, Yakin',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.value) {

                    // let url = "penguji/ujian/" + peserta_id + "/tidak-hadir";

                    window.location.href = "{{url('osce/penguji/ujian')}}" + "/" + peserta_id + "/tidak-hadir";

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                }
            })

        });

    </script>

    <script>
        $("#btn-check-nilai").on('click', function() {

            $.ajax({
                url: "{{ url('soca/penguji/ujian/check-gap-point') }}",
                type: "POST",
                data: $("#form-penilaian").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(response) {
                    console.log("SUCCESS:", response);

                    if (response.status == 'success') {
                        $("#status-nilai").css('color', 'green');
                        $("#status-nilai").html('Sinkron')

                    } else {
                        $("#status-nilai").css('color', 'red');
                        $("#status-nilai").html('Tidak Sinkron')
                    }

                },
                error: function(xhr) {
                    console.log("ERROR:", xhr.responseText);
                }
            });


        });
    </script>

    <script>
        $(document).on('change', '.point-radio', function() {

            let step = $(this).data('step');
            let stepItem = $('.step-item[data-step="'+ step +'"]');

            stepItem.addClass('done');
        });
    </script>
@endpush
