@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')

    <style>
        .indikator-box {
            height: 500px !important; /* or any fixed height you need */
            display: flex;
            flex-direction: column;
            position: relative !important;
            /* border: 1px solid #ccc; */
            padding: 10px !important;
            width: 100% !important;
        }

        /* Scrollable text */
        .scroll-area {
            flex: 1;               /* take all available space except footer */
            overflow-y: auto;      /* makes it scrollable */
            margin-bottom: 10px;
        }

        /* Footer fixed at bottom of the section */
        .footer-ujian {
            padding: 8px;
            background: #f1f1f1;
            border-top: 1px solid #ccc;
            text-align: center;
            flex-shrink: 0;        /* prevents footer from shrinking */
        }

        .wizard.vertical > .content {
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
        <h4 class="card-title text-center" style="font-size: 20px">{{$peserta->stationOsce->ujianOsce->nama}} ( {{$peserta->mahasiswa->nim}} / {{$peserta->mahasiswa->nama}} )</h4>
        <h4 class="text-center" style="font-size: 18px; margin-bottom: 12px">Station : {{$peserta->stationOsce->no_station}}</h4>

        <form id="form-penilaian" action="{{url('osce/penguji/penilaian-ujian')}}" method="POST">
            @csrf
            <input type="hidden" name="id_peserta" value="{{$peserta->id}}">
            <input type="hidden" name="id_ujian" value="{{$peserta->stationOsce->ujianOsce->id}}">
            <div id="wizardVertical">
                @php($iter = 0)
                @foreach ($peserta->stationOsce->ujianOsce->indikatorOsce as $key => $item)
                    @php($iter++)
                    <h2>{{$item->nama}}</h2>
                    <section class="indikator-box">
                        <div class="d-flex justify-content-between">
                            <h4>{{$item->nama}}</h4>
                            <p class="badge bg-warning text-dark mt-1">Bobot : {{$item->bobot}}</p>
                        </div>

                        <div class="scroll-area">
                            <p>{{$item->deskripsi}}</p>
                        </div>

                        <div class="footer-ujian">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{$key}}]" id="inlineRadio0" value="0">
                                <label class="form-check-label" for="inlineRadio0">0</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{$key}}]" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{$key}}]" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="nilai[{{$key}}]" id="inlineRadio3" value="3" checked>
                                <label class="form-check-label" for="inlineRadio3">3</label>
                            </div>
                        </div>

                    </section>
                @endforeach
            </div>

            <div class="form-group mt-3">
                <label for="" class="form-label">Silahkan isi Feedback</label>
                <textarea id="feedback" class="form-control" rows="5" name="feedback" required></textarea>
            </div>
        </form>


      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard.js') }}"></script>

  <script>

    $("#wizardVertical").steps({

        onStepChanging: function (event, currentIndex, newIndex) {

            let indikator = @json($peserta->stationOsce->ujianOsce->indikatorOsce);
            let total_indikator = indikator.length;

            for(let i = 0; i < total_indikator; i++) {
                let nilai = $('input[name="nilai-' + i + '"]').val();
            }

            if(localStorage.getItem("nilai") !== null) {

            }

            // console.log(nilai)
            return true; // allow to continue
        },
        onFinished: function (event, currentIndex) {

            let is_complete = true;

            let feedback = $("#feedback").val();

            if(! feedback) {
                is_complete = false;
            }

            if(is_complete) {

                $.ajax({
                    url: "{{url('osce/penguji/ujian/check-station/')}}" + "/" + "{{$peserta->id}}",
                    type: "GET",
                    // data: $("#form-penilaian").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(response) {
                        console.log("SUCCESS:", response);

                        if(response.status == 'complete') {
                        //     $("#status-nilai").css('color', 'green');
                        //     $("#status-nilai").html('Sinkron')
                            $("#form-penilaian").submit();

                        } else {
                        //     $("#status-nilai").css('color', 'red');
                        //     $("#status-nilai").html('Tidak Sinkron')
                        }

                    },
                    error: function(xhr) {
                        console.log("ERROR:", xhr.responseText);
                    }
                });

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

@endpush
