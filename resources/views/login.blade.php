@extends('layout.master2')

@section('content')

<style>
    .alert-overlay {
    position: fixed;
    top: 30px; /* Distance from the top */
    left: 50%;
    /* Move back 50% of its own width to center horizontally */
    transform: translateX(-50%);
    z-index: 9999;

    min-width: 320px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);

    display: flex;
    align-items: center;
    gap: 12px;

    /* Animation: Slide down */
    animation: slideDown 0.4s ease-out forwards;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translate(-50%, -100%); /* Start off-screen top */
    }
    to {
        opacity: 1;
        transform: translate(-50%, 0);
    }
}
</style>
@if(session('page_error'))
    <div class="alert alert-danger alert-overlay alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-alert-circle me-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>

            <div>
                {{ session('page_error') }}
            </div>
        </div>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper d-flex justify-content-center align-items-center">
                <img src="{{asset('assets/images/logo-fk.png')}}" alt="Logo" style="width: 160px; height: 250px">
            </div>
          </div>

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

          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">Medical Examination</a>
              <h5 class="text-muted fw-normal mb-4">Fakultas Kedokteran UIN Sunan Ampel Surabaya</h5>
              <form id="form-login" method="POST" class="forms-sample" action="{{url('login')}}">
                @csrf
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password" name="password">

                    <span class="input-group-text" style="cursor: pointer;">
                        <i class="fa fa-eye" id="togglePassword"></i>
                    </span>
                </div>
                </div>
                <button class="btn btn-primary w-100" style="background-color: #125335; border: none">Login</button>

                <div>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            // 1. Select the input field
            const passwordInput = $('#userPassword');

            // 2. Get the current type
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';

            // 3. Switch the input type
            passwordInput.attr('type', type);

            // 4. Toggle the eye icon (open/closed)
            // Assuming you use FontAwesome: fa-eye (open) and fa-eye-slash (closed)
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        // Select the alert
        var $alert = $('.alert-overlay');

        // Only run if the alert actually exists
        if ($alert.length) {
            // Wait 4 seconds, then fade out
            setTimeout(function() {
                $alert.fadeOut('slow');
            }, 4000);
        }
    });

</script>
@endsection
