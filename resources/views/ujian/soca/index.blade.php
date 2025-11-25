@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-steps/jquery.steps.css') }}" rel="stylesheet" />
@endpush

@section('content')

    <style>
        .indikator-box {
            height: 500px !important;  /* or any fixed height you need */
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
        <h3 class="card-title text-center" style="font-size: 20px">{{$peserta->ujianSoca->nama}} ( {{$peserta->mahasiswa->nim}} / {{$peserta->mahasiswa->nama}} )</h3>

        <div class="d-flex">
            <button type="button" id="btn-check-nilai" class="btn btn-secondary btn-sm mb-3 me-4">Check Nilai</button>
            <h6 class="mt-2">Status Nilai : <span id="status-nilai">Tidak Sinkron</span></h6>
        </div>

        <form id="form-penilaian" action="{{url('soca/penguji/penilaian-ujian')}}" method="POST">
            @csrf

            <input type="hidden" name="tipe_penguji" value="{{$tipe_penguji}}">
            <input type="hidden" name="id_peserta" value="{{$peserta->id}}">
            <input type="hidden" name="id_ujian" value="{{$peserta->ujianSoca->id}}">
            <div id="wizardVertical">

                @php($iter = 0)
                @foreach ($peserta->ujianSoca->indikatorSoca as $key => $item)
                    @php($iter++)
                    <h2>{{$item->nama}}</h2>
                    <section class="indikator-box">
                        <h4 class="mb-3">{{$item->nama}}</h4>
                        <input type="hidden" name="indikator[{{$key}}]" value="{{$item->id}}">

                        <div class="scroll-area">
                            <p>{{$item->deskripsi}}</p>
                        </div>

                        <div class="footer-ujian">
                            @for ($i = 0; $i < $item->skormax; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nilai[{{$key}}]" id="inlineRadio1" value="{{$i + 1}}" checked>
                                    <label class="form-check-label" for="inlineRadio1">{{$i + 1}}</label>
                                </div>
                            @endfor
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

<script>

</script>

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/wizard.js') }}"></script>
  <script>

    $("#wizardVertical").steps({

        onStepChanging: function (event, currentIndex, newIndex) {

            let indikator = @json($peserta->ujianSoca->indikatorSoca);
            let total_indikator = indikator.length;

            for(let i = 0; i < total_indikator; i++) {
                let nilai = $('input[name="nilai-' + i + '"]').val();
            }


            if(localStorage.getItem("nilai") !== null) {

            }

            return true; // allow to continue
        },
        onFinished: function (event, currentIndex) {

            let is_complete = true;

            let feedback = $("#feedback").val();

            if(! feedback) {
                is_complete = false;
            }

            let status_penilaian = $("#status-nilai").html();

            if(status_penilaian != "Sinkron") {
                is_complete = false;
            }

            if(is_complete) {
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
            url: "{{url('soca/penguji/ujian/check-gap-point')}}",
            type: "POST",
            data: $("#form-penilaian").serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(response) {
                console.log("SUCCESS:", response);

                if(response.status == 'success') {
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
