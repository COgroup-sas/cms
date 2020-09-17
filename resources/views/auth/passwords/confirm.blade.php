@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center h-100">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <!-- Material form login -->
      <div class="card login">
        <div class="card-header primary-color white-text text-center py-4">{{ __('99o.Confirm_Password') }}</div>

        <div class="card-body">
          {{ __('99o.Please_confirm_your_password_before_continuing.') }}

          <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-12 col-md-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-2">
                <button type="submit" class="btn btn-primary">
                  {{ __('Confirm Password') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('Forgot Your Password?') }}
                </a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
