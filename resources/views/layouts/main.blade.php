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
  <link rel="shortcut icon" href="{{ (!isset(cms_settings()->favicon) || empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('files.getFile', cms_settings()->favicon) }}" type="{{ (!isset(cms_settings()->favicon) || empty(cms_settings()->favicon)) ? 'image/png' : cms_get_file_attribute(cms_settings()->favicon, 'mimetype') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ cms_settings()->sitedescription }}" />
  <meta name="keywords" content="{{ cms_settings()->sitekeywords   }}" />
  <meta name="author" content="www.cogroupsas.com" />

  @yield('css')

  <link rel="stylesheet" href="{{ asset('vendor/cogroup/cms/css/app.css?'.time()) }}">
  <link rel="stylesheet" href="{{ asset('css/app.css?'.time()) }}">
  <!-- Scripts -->
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
  @if(!is_null(cms_settings()->analyticscode)){{ cms_settings()->analyticscode }}@endif
</head>
<body class="{{ config('cogroupcms.color_theme') }}">
  @include('cogroupcms::partials.preloader')
  @include('cogroupcms::partials.header')

  <main class="mt-5 pt-5">
    <div class="container-fluid">
      @yield('content')
    </div>
  </main>

  @include('cogroupcms::partials.footer')

  @if(Session::has('status'))
  <div id="toast-container" class="cogtoast md-toast-{{ Session::has('msgfrom') ? Session::get('msgfrom') : 'top' }}-{{ Session::has('msgalign') ? Session::get('msgalign') : 'right' }}" aria-live="polite" role="alert" data-autohide="true" data-delay="{{ Session::has('msgtime') ? Session::get('msgtime') : 4000 }}">
    <div class="md-toast md-toast-@switch(Session::get('status'))
      @case(0){{ 'error' }}@break
      @case(1){{ 'success' }}@break
      @case(2){{ 'info' }}@break
      @case(3){{ 'warning' }}@break
    @endswitch" style="">
      <div class="md-toast-message">{{ Session::get('msg') }}</div>
    </div>
  </div>
  @endif

  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
    var CMS_SITE = "{{ route('cogroupcms.home') }}";
  </script>
  <script src="{{ asset('vendor/cogroup/cms/js/app.js?'.time()) }}"></script>
  <script src="{{ asset('vendor/cogroup/cms/js/mdb.min.js') }}"></script>
  <script src="{{ asset('js/app.js?'.time()) }}"></script>

  @yield('scripts')
</body>
</html>