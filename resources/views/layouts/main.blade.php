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

  @if (!empty($csss))
    @foreach ($csss as $css)
  <link href="{{ $css[0] }}" rel="stylesheet" media="{{ $css[1].'?'.time() }}">
    @endforeach
  @endif

  <link rel="stylesheet" href="{{ asset('vendor/cogroup/cms/css/app.css?'.time()) }}">
  <link rel="stylesheet" href="{{ asset('css/app.css?'.time()) }}">
  <!-- Scripts -->
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
</head>
<body class="{{ config('cogroupcms.color_theme') }}">
  @include('cogroupcms::partials.preloader')
  <div class="wrapper">
    @include('cogroupcms::partials.sidebar')
    <div class="main-panel">
      @include('cogroupcms::partials.header')
      <div class="content">
        @yield('content')
      </div>
      @include('cogroupcms::partials.footer')
    </div>
  </div>

  @if(Session::has('status'))
  <div class="hidden notification"
    data-placement-from="{{ Session::has('msgfrom') ? Session::get('msgfrom') : 'top' }}" 
    data-placement-align="{{ Session::has('msgalign') ? Session::get('msgalign') : 'right' }}" 
    data-time="{{ Session::has('msgtime') ? Session::get('msgtime') : 4000 }}" 
    data-color-name="{{ (Session::get('status') == 1) ? 'info' : 'danger' }} " 
    data-text="{{ Session::get('msg') }}">SUCCESS</div>
  @endif

  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
    var CMS_SITE = "{{ config('cogroupcms.uri', 'cms') }}";
  </script>
  <script src="{{ asset('vendor/cogroup/cms/js/app.js?'.time()) }}"></script>
  <script src="{{ asset('vendor/cogroup/cms/js/datatables.net/js/jquery.dataTables.js?'.time()) }}"></script>
  <script src="{{ asset('vendor/cogroup/cms/js/datatables.net-bs4/js/dataTables.bootstrap4.js?'.time()) }}"></script>
  <script src="{{ asset('vendor/cogroup/cms/js/jquery-datatable.js?'.time()) }}"></script>
  <script src="{{ asset('js/app.js?'.time()) }}"></script>

  @if (!empty($scripts))
  @foreach ($scripts as $js)
  <script @if (!empty($js['type'])) type="{{ $js['type'] }}" @endif src="{{ $js['src'].'?'.time() }}"></script>
    @endforeach
  @endif
</body>
</html>