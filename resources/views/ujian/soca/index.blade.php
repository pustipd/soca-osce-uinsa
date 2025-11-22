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
        <h4 class="card-title">Ujian SOCA ({{$ujian->ujianSoca->kriteriaSoca->nama}})</h4>

        <form id="form-penilaian" action="{{url('soca/penguji/penilaian-ujian')}}" method="POST">
            @csrf
            <input type="hidden" name="id_peserta" value="{{$ujian->id}}">
            <input type="hidden" name="id_kriteria" value="{{$ujian->ujianSoca->kriteriaSoca->id}}">
            <div id="wizardVertical">
                @php($iter = 0)
                @foreach ($ujian->ujianSoca->kriteriaSoca->indikatorSoca as $key => $item)
                    @php($iter++)
                    <h2>Indikator {{$iter}}</h2>
                    <section class="indikator-box">
                        <h4 class="mb-3">Indikator {{$iter}}</h4>

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
        </form>

          {{-- <h2>Second Step</h2>
          <section>
            <h4>Second Step</h4>
            <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque.
                In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum
                dictum, nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien a diam adipiscing consectetur.
                In euismod augue ullamcorper leo dignissim quis elementum arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Vestibulum leo velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis iaculis nec, malesuada a diam.
                Donec non pulvinar urna. Aliquam id velit lacus.</p>
          </section>

          <h2>Third Step</h2>
          <section>
            <h4>Third Step</h4>
            <p>Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo condimentum dapibus. Fusce eros justo,
                pellentesque non euismod ac, rutrum sed quam. Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.
                Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui commodo lectus sollicitudin in auctor mauris
                venenatis.</p>
          </section>

          <h2>Fourth Step</h2>
          <section>
            <h4>Fourth Step</h4>
            <p>Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor.
                Quisque sed felis ut mauris feugiat iaculis nec ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.
                Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo tortor.</p>
          </section> --}}
        </div>

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

            let indikator = @json($ujian->ujianSoca->kriteriaSoca->indikatorSoca);
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
