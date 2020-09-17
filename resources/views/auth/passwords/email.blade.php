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

  <link rel="stylesheet" href="{{ asset('vendor/cogroup/cms/css/app.css?'.time()) }}">
  <link rel="stylesheet" href="{{ asset('css/app.css?'.time()) }}">
  <!-- Scripts -->
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>

  <style type="text/css">
    html,
    body {
      height: 100%;
    }
    header {
      height: calc(100vh - 56px);
    }

    @media screen and (max-width: 767px) {
      header {
        height: calc(100vh - 128px) !important;
      }
    }

    #intro {
      background: url("{{ config('app.url')."/".config('cogroupcms.bguri') }}")no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>
<body class="{{ config('cogroupcms.color_theme') }} login-page sidebar-collapse">
  @include('cogroupcms::partials.preloader')

  <header>

    <!--Mask-->
    <div id="intro" class="view h-100">

      <div class="mask" filter-background-linear-color="{{ config('cogroupcms.color_theme') }}">

        <div class="container-fluid d-flex align-items-center justify-content-center h-100 scrollbar-primary">
          <div class="row justify-content-center">
            <div class="col-12">
              <!-- Material form login -->
              <div class="card login opacity-80" data-background-color="white">

                <h5 class="card-header text-center py-3" data-background-color="transparent">
                  <img src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'orange').'/logocms.png') : route('getFile', cms_settings()->logo) }}" alt="{{ cms_settings()->sitename }}" class="img-fluid w-50 m-auto">
                </h5>

                <!--Card content-->
                <div class="card-body px-lg-4 pt-0">

                  <!-- Form -->
                  <form class="text-center needs-validation text-color" data-color="dark" novalidate method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="md-form">
                      <input type="text" id="LoginFormEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                      <label for="LoginFormEmail">{{ __('validation.attributes.email') }}</label>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <!-- Sign in button -->
                    <button class="btn btn-theme btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">{{ __('cms.textbtnresetpassword') }}</button>

                    <div class="d-flex justify-content-around">
                      <div>
                        <!-- return back -->
                        <a href="{{ route('cogroupcms.home') }}">{{ __('cms.back') }}</a>
                      </div>
                    </div>

                  </form>
                  <!-- Form -->

                </div>

              </div>
              <!-- Material form login -->
            </div>
          </div>
        </div>

      </div>

    </div>
    <!--/.Mask-->

    @include('cogroupcms::partials.footer')

  </header>

  <!-- Scripts -->
  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
    var CMS_SITE = "{{ config('cogroupcms.uri', 'cms') }}";
  </script>
  <script src="{{ asset('vendor/cogroup/cms/js/app.js?'.time()) }}"></script>
  <script src="{{ asset('vendor/cogroup/cms/js/mdb.min.js') }}"></script>
  <script src="{{ asset('js/app.js?'.time()) }}"></script>
</body>
</html>