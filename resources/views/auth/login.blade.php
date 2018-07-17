<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ cms_settings()->sitename }}@if(isset($title)){{ " .::. ".$title }}@endif</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ (!isset(cms_settings()->favicon) || empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('getFile', cms_settings()->favicon) }}" type="{{ (!isset(cms_settings()->favicon) || empty(cms_settings()->favicon)) ? 'image/png' : cms_get_file_attribute(cms_settings()->favicon, 'mimetype') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ cms_settings()->sitedescription }}" />
  <meta name="keywords" content="{{ cms_settings()->sitekeywords   }}" />
  <meta name="author" content="www.cogroupsas.com" />

  <link rel="stylesheet" href="{{ asset('css/app.css?'.time()) }}">
  <link rel="stylesheet" href="{{ asset('vendor/cogroup/cms/css/app.css?'.time()) }}">
  <!-- Scripts -->
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
</head>
<body class="{{ config('cogroupcms.color_theme', 'light-blue') }} login-page sidebar-collapse">
  @include('cogroupcms::partials.preloader')

  <div class="page-header" filter-color="orange">
    <div class="page-header-image" style="background-image:url({{ asset('vendor/cogroup/cms/images/bg.jpg') }})"></div>
    <div class="container">
      <div class="col-md-4 content-center">
        <div class="card card-login card-plain">
          <form method="POST" action="{{ route('login') }}" class="form needs-validation" novalidate>
            @csrf
            <div class="header header-primary text-center">
              <div class="logo-container">
                <img src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'orange').'/logocms.png') : route('getFile', cms_settings()->logo) }}" alt="{{ cms_settings()->sitename }}">
              </div>
            </div>
            <div class="content">
              <div class="input-group form-group-no-border input-lg">
                <div class="input-group-prepend">
                  <span class="input-group-addon input-group-text" id="basic-addon1">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" placeholder="{{ trans('validation.attributes.email') }}">
              </div>
              @if ($errors->has('email'))
                <span class="text-warning">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
              <div class="input-group form-group-no-border input-lg">
                <div class="input-group-prepend">
                  <span class="input-group-addon input-group-text" id="basic-addon1">
                    <i class="fa fa-key"></i>
                  </span>
                </div>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ trans('validation.attributes.password') }}">
              </div>
              @if ($errors->has('password'))
                <span class="text-warning">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
              <div class="input-group form-group-no-border input-lg">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" id="customCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="form-check-sign"></span>
                    {{ trans('cms.rememberme') }}
                  </label>
                </div>
              </div>
            </div>
            <div class="footer text-center">
              <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">
                {{ trans('cms.textbtnsignin') }}
              </button>
            </div>
            <div class="{{ (cms_settings()->socialaccess == 1) ? 'pull-left' : '' }}">
              <h6>
                <a class="link" href="{{ route('password.request') }}">
                  {{ trans('cms.linkforgotpassword') }}
                </a>
              </h6>
            </div>
            @if(cms_settings()->socialaccess == 1)
            <div class="pull-right">
              <h6>
                <a class="link" href="{{ url('login/google') }}"><i class="fab fa-google"></i> Google</a>
                <a class="link" href="{{ url('login/facebook') }}"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a class="link" href="{{ url('login/twitter') }}"><i class="fab fa-twitter"></i> Twitter</a>
              </h6>
            </div>
            @endif
          </form>
        </div>
      </div>
    </div>
    @include('cogroupcms::partials.footer')
  </div>

  <!-- Scripts -->
  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
    var CMS_SITE = "{{ config('cogroupcms.uri', 'cms') }}";
  </script>
  <script src="{{ asset('vendor/cogroup/cms/js/app.js?'.time()) }}"></script>
  <script src="{{ asset('js/app.js?'.time()) }}"></script>
</body>
</html>