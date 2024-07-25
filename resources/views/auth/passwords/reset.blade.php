@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
            <img class="mx-auto d-block w-50" src="{{asset('images/poweron_logo_with_text.svg')}}" >
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
            <div class="card">
                <div class="card-body p-0 m-0">
                    <form method="POST" action="{{ route('auth.reset') }}" id="resetpassword">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">{{ __('Reset Password') }}</h5>
                        <hr class="m-0">

                        <div class="px-5 py-4">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="email" class=" col-form-label text-md-right mt-0 pt-0" >{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="password" class=" col-form-label text-md-right mt-0 pt-0" >{{ __('Password') }}</label>
                                    <input id="password" placeholder="Enter Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required minlength="8" autocomplete="new-password">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="password-confirm" class=" col-form-label text-md-right mt-0 pt-0" >{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" placeholder="Enter Password Again" class="form-control" name="password_confirmation" required minlength="8">
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-0">
                                <div class="col-sm-6 mb-3 mx-auto">
                                    <a href="{{ route('logout') }}" class="btn rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100" >
                                        CANCEL
                                    </a>
                                </div>
                                <div class="col-sm-6 mb-3 mx-auto">
                                    <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100" type="submit">{{ __('RESET PASSWORD') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js-script')
<script>
    $(document).ready(function() {
        var validity = false;
        $('#password').on('change', checkPasswordMatch);
        $('#password-confirm').on('change', checkPasswordMatch);

        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#password-confirm").val();

            if(password.length > 7 && confirmPassword.length > 7) {
                var fldObj = $(this);

                if (password != confirmPassword) {
                    fldObj[0].setCustomValidity('Passwords do not match!');
                    validity = false;

                } else {
                    fldObj[0].setCustomValidity('');
                    validity = true;
                }
            }
        }

        $( "#resetpassword" ).submit(function( event ) {
            if(!validity) {
                event.preventDefault();
            }
        });
    });
</script>
@stop
