<div class="container-fluid">
  <div class="row">
    @if(Auth::check())
    <nav class="col-md-2 d-none d-md-block sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          @foreach($modules as $module)
          <li class="nav-item">
            <a class="nav-link" href="{{ url($module->url) }}"><i class="{{ $module->icon }}"></i> {{ $module->modulename }}</a>
          </li>
          @endforeach
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" 
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out-alt"></i> Salir
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    @endif
      @include('partials.breadcrumb')
      @yield('content')
    @if(Auth::check())
    </main>
    @endif
  </div>
</div>