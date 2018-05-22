<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env("APP_NAME") }} - @yield('title')</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ asset('vendor/cogroup/cms/images/favicon.png') }}" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @php /*<meta name="description" content="{{ $settings->sitedescription }}" />
  <meta name="keywords" content="{{ $settings->sitekeywords   }}" />*/ @endphp
  <meta name="author" content="www.cogroupsas.com" />
  <link rel="stylesheet" href="{{ asset('vendor/cogroup/cms/css/app.css?'.time()) }}">
  <!-- Scripts -->
</head>
<body class="{{ config('cogroupcms.color_theme', 'light-blue') }} error-page">
  @include('cogroupcms::partials.preloader')
  <div class="page-header" filter-color="orange">
    <div class="page-header-image" style="background-image:url({{ asset('vendor/cogroup/cms/images/bg.jpg') }})"></div>
    <div class="container text-error">
      <p class="number-error text-danger">@yield('number') <i class="@yield('icon')"></i></p>
      <p>@yield('message')</p>
    </div>
    @include('cogroupcms::partials.footer')
  </div>

  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
    var CMS_SITE = "{{ config('cogroupcms.uri', 'cms') }}";
  </script>
  <script src="{{ asset('vendor/cogroup/cms/js/app.js?'.time()) }}"></script>
</body>
</html>