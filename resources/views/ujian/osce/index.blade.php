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
        <h4 class="card-title">Ujian OSCE ({{$ujian->stationOsce->ujianOsce->kriteriaOsce->nama}})</h4>

        <form id="form-penilaian" action="{{url('osce/penguji/penilaian-ujian')}}" method="POST">
            @csrf
            <input type="hidden" name="id_peserta" value="{{$ujian->id}}">
            <input type="hidden" name="id_kriteria" value="{{$ujian->stationOsce->ujianOsce->id_kriteria}}">
            <div id="wizardVertical">
                @php($iter = 0)
                @foreach ($ujian->stationOsce->ujianOsce->kriteriaOsce->indikatorOsce as $key => $item)
                    @php($iter++)
                    <h2>Indikator {{$iter}}</h2>
                    <section class="indikator-box">
                        <h4>Indikator {{$iter}}</h4>

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
            </form>

        </div>

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

            let indikator = @json($ujian->stationOsce->ujianOsce->kriteriaOsce->indikatorSoca);
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

            $("#form-penilaian").submit();

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
