<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="http://www.creative-tim.com" class="simple-text logo-normal">
      <img src="{{ asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'light-blue').'/logocms.png') }}">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="active">
        <a href="{{ route('cogroupcms.home') }}"><i class="fa fa-home"></i> {{ trans('cms.home') }}</a>
      </li>
      @foreach($modules as $module)
      <li class="">
        <a href="{{ url($module->url) }}"><i class="{{ $module->icon }}"></i> {{ $module->modulename }}</a>
      </li>
      @endforeach
    </ul>
  </div>
</div>