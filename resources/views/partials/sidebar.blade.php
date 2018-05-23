<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="http://www.creative-tim.com" class="simple-text logo-normal">
      <img src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'orange').'/logocms.png') : route('getFile', cms_settings()->logo) }}">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="{{ ($route == 'cms') ? 'active' : '' }}">
        <a href="{{ route('cogroupcms.home') }}"><i class="fa fa-home"></i> {{ trans('cms.home') }}</a>
      </li>
      @foreach($modules as $module)
      <li class="{{ starts_with($route, $module->url) ? 'active' : '' }}">
        <a{!! (isset($module->submod) and !empty($module->submod) and count($module->submod) > 0) ? ' data-toggle="collapse"  aria-expanded="false" aria-controls="'.str_slug($module->moduleslug).'"' : '' !!} href="{!! (isset($module->submod) and !empty($module->submod) and count($module->submod) > 0) ? "#".str_slug($module->moduleslug) : url($module->url) !!}"><i class="{{ $module->icon }}"></i> <p>{{ $module->modulename }} {!! (isset($module->submod) and !empty($module->submod) and count($module->submod) > 0) ? '<b class="caret"></b>' : '' !!}</p></a>
        @if(isset($module->submod) and !empty($module->submod) and count($module->submod) > 0)
        <div class="collapse" id="{{ str_slug($module->moduleslug) }}">
          {{ cms_print_submenu($module->submod, $route) }}
        </div>
        @endif
      </li>
      @endforeach
    </ul>
  </div>
</div>