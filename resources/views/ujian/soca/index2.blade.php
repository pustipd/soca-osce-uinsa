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
            background: #6571ff;
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

    {{-- <nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">Wizard</li>
  </ol>
</nav> --}}

    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-4">
                        <p></p>
                        <h5>{{ $penguji->ujianSoca->nama }} Sesi {{ $penguji->ujianSoca->sesi }}</h5>
                        <p>Total Nilai : <span class="badge bg-warning text-dark">10</span></p>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <!-- LEFT: CONTENT -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">

                                            <form id="wizardForm">
                                                <div id="wizardContents">
                                                    @foreach ($list_indikator as $key => $indikator)
                                                        <div class="step-content {{ $key == 0 ? 'active' : '' }}"
                                                            data-step="{{ $key + 1 }}">

                                                            <!-- Scrollable content wrapper -->
                                                            <div class="step-scroll">
                                                                <h4 class="mb-3">
                                                                    {{ Str::limit($indikator->deskripsi, 10) }}</h4>

                                                                <div class="form-group">
                                                                    <label>{{ Str::limit($indikator->deskripsi, 10) }}</label>
                                                                    <div class="text-block">
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                        elit...
                                                                        <br><br>
                                                                        This is all inside a <strong>div</strong>.
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Fixed footer -->
                                                            <div class="form-footer">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="nilai[{{ $key }}]" id="inlineRadio1"
                                                                        value="1" checked>
                                                                    <label class="form-check-label"
                                                                        for="inlineRadio1">1</label>
                                                                </div>

                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="nilai[{{ $key }}]" id="inlineRadio1"
                                                                        value="1" checked>
                                                                    <label class="form-check-label"
                                                                        for="inlineRadio1">1</label>
                                                                </div>

                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="nilai[{{ $key }}]" id="inlineRadio1"
                                                                        value="1" checked>
                                                                    <label class="form-check-label"
                                                                        for="inlineRadio1">1</label>
                                                                </div>

                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="nilai[{{ $key }}]" id="inlineRadio1"
                                                                        value="1" checked>
                                                                    <label class="form-check-label"
                                                                        for="inlineRadio1">1</label>
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

                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <!-- RIGHT: STEPPER -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="wizard-steps-right">
                                                @foreach ($list_indikator as $key => $item)
                                                    <div class="step-item {{ $key == 0 ? 'active' : '' }}"
                                                        data-step="{{ $key + 1 }}">{{ $key + 1 }}.
                                                        {{ Str::limit($item->deskripsi, 10) }}</div>
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
                                    <div class="badge bg-primary w-100 p-2">
                                        <p class="text-center">Mahasiswa 1</p>
                                    </div>
                                    <div class="badge bg-secondary w-100 mt-2 p-2">
                                        <p class="text-center">Mahasiswa 1</p>
                                    </div>
                                    <div class="badge bg-secondary w-100 mt-2 p-2">
                                        <p class="text-center">Mahasiswa 1</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="form-label">Feedback untuk mahasiswa</label>
                                <textarea name="feedback" class="form-control" id="feedback" cols="10" rows="5"></textarea>
                            </div>

                            <button class="btn btn-primary w-100 mt-3">Simpan Penilaian</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

<script></script>

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
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
                document.getElementById('btnNext').innerText = "Submit";
            } else {
                document.getElementById('btnNext').innerText = "Next";
            }
        }

        document.getElementById('btnPrev').addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        document.getElementById('btnNext').addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                document.getElementById('wizardForm').submit();
            }
        });

        // Initialize first step
        showStep(currentStep);
    </script>

    <script src="{{ asset('assets/js/wizard.js') }}"></script>
    <script>
        $("#wizardVertical").steps({

            onStepChanging: function(event, currentIndex, newIndex) {

                return true; // allow to continue
            },
            onFinished: function(event, currentIndex) {

                let is_complete = true;

                let feedback = $("#feedback").val();

                if (!feedback) {
                    is_complete = false;
                }

                let status_penilaian = $("#status-nilai").html();

                if (status_penilaian != "Sinkron") {
                    is_complete = false;
                }

                if (is_complete) {
                    $("#form-penilaian").submit();
                }

                // Submit form, AJAX, redirect, etc.
                // Example:
                // $("#formWizard").submit();
            },
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            stepsOrientation: 'vertical'
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
@endpush
