<!-- Sidebar navigation -->
<div id="mySidenav" class="sidenav">
  <div id="vertical-accordion-menu" class="vertical-accordion-menu">
    <div class="vertical-accordion-menu-header waves-light logo-wrapper">
      <a href="{{ route('cogroupcms.home') }}">
        <img src="{{ (empty(cms_settings()->logocontraste)) ? asset('vendor/cogroup/cms/images/logocmscontraste.png') : route('files.getFile', cms_settings()->logocontraste) }}" class="img-fluid flex-center mx-auto">
      </a>
    </div>
    <ul class="scrollbar scrollbar-primary scrollbar-menu">
      <li class="{{ ( \Request::is('/') ) ? 'active' : '' }}"><a href="{{ config('cogroupcms.uri') }}"><i class="fa fa-home"></i>{{ __('cms.home') }} </a></li>

      @foreach($modules as $module)
      <li class="{{ ( \Request::is($module['url']) ) ? 'active' : '' }}">
        <a href="{{ route($module['url']) }}"><i class="{{ $module['icon'] }}"></i> {{ $module['modulename'] }}</a>
        @if(isset($module['submod']) and !empty($module['submod']) and count($module['submod']) > 0)
        {{ cms_print_submenu($module['submod'], $route) }}
        @endif
      </li>
      @endforeach
    </ul>
    <div class="vertical-accordion-menu-footer fixed-bottom fs-0-8 text-center p-1">{{ cms_version() }}</div>
  </div>
</div>
<!--/. Sidebar navigation -->