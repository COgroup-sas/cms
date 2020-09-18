@extends('cogroupcms::layouts.main')

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-md-8">
    <!-- Material form -->
    <div class="card login">
      <div class="card-header primary-color white-text text-center py-4">{{ __('99o.Verify_Your_Email_Address') }}</div>

      <div class="card-body">
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
          {{ __('99o.A_fresh_verification_link_has_been_sent_to_your_email_address') }}.
        </div>
        @endif

        {{ __('99o.Before_proceeding_please_check_your_email_for_a_verification_link') }}.
        {{ __('99o.If_you_did_not_receive_the_email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
          @csrf
          <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('99o.click_here_to_request_another') }}</button>.
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
