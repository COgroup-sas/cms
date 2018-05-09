<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env("APP_NAME") }}</title>
  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @php /*<meta name="description" content="{{ $settings->sitedescription }}" />
  <meta name="keywords" content="{{ $settings->sitekeywords   }}" />*/ @endphp
  <meta name="author" content="www.cogroupsas.com" />

  @if (!empty($csss))
    @foreach ($csss as $css)
  <link href="{{ $css[0] }}" rel="stylesheet" media="{{ $css[1].'?'.time() }}">
    @endforeach
  @endif

  <link rel="stylesheet" href="{{ asset('css/app.css?'.time()) }}">
  <link rel="stylesheet" href="{{ asset('themecms/plugins/bootstrap-jasny/css/jasny-bootstrap.min.css') }}">
  <!-- Scripts -->
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
</head>
<body class="adminpanel">
  @include('admin.partials.header')
  @include('admin.partials.content')
  
  <footer class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">© {{ date("Y") }} {{ trans('cms.rights') }}</div>
      <div class="col-6 offset-md-3">
        <div class="row">
          <div class="col-4"><i class="fa fa-phone"></i> {{ $settings->phone }}</div>
          <div class="col-4"><i class="fa fa-map-marker"></i> {{ $settings->address }}</div>
          <div class="col-4"><i class="fa fa-envelope"></i> {{ $settings->emailaddress }}</div>
        </div>
      </div>
    </div>
  </footer>

  @if(Session::has('status'))
  <div class="hidden notification"
    data-placement-from="bottom" 
    data-placement-align="center" 
    data-animate-enter="" 
    data-animate-exit="" 
    data-color-name="{{ (Session::get('status') == 1) ? 'alert-success' : 'alert-danger' }} " 
    data-text="{{ Session::get('msg') }}">SUCCESS</div>
  @endif

  <!-- Scripts -->
  <script>
    var lang = '{{ Session::get('applocale') }}';
    var SITE_URL = "{{ URL::to('/') }}/";
  </script>
  <script src="{{ asset('js/app.js?'.time()) }}"></script>
  <script src="{{ asset('js/datatables.net/js/jquery.dataTables.js?'.time()) }}"></script>
  <script src="{{ asset('js/datatables.net-bs4/js/dataTables.bootstrap4.js?'.time()) }}"></script>
  <script src="{{ asset('themecms/js/jquery-datatable.js?'.time()) }}"></script>

  @if (!empty($scripts))
  @foreach ($scripts as $js)
  <script @if (!empty($js['type'])) type="{{ $js['type'] }}" @endif src="{{ $js['src'].'?'.time() }}"></script>
    @endforeach
  @endif
</body>
</html>