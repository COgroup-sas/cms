<!--Double navigation-->
<header>
  <!-- Sidebar navigation -->
  @if(count($modules) > 0)
  @include('cogroupcms::partials.sidebar')
  @endif
  <!--/. Sidebar navigation -->

  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar" data-background-color="{{ config('cogroupcms.color_theme') }}">

    <div class="container">

      <!-- Navbar brand -->
      @if(count($modules) > 0)
      <a class="navbar-brand open-nav" href="#">
        <i class="fas fa-bars"></i>
      </a>
      @endif

      <a class="navbar-brand" href="{{ config('app.url') }}">
        <img src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/logocmscontraste.png') : route('getFile', cms_settings()->logo) }}" class="img-fluid flex-center">
      </a>

      <!-- Collapse button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <ul class="navbar-nav ml-auto nav-flex-icons">
          @auth
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="{{ route('notifications.home') }}">
              <i class="fas fa-bell fa-lg"></i> <sup><span class="badge badge-pill badge-warning">{{ cms_get_total_unread_notifications() }}</span></sup>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              @if(Auth::user()->avatar != NULL)
              <img src="{{ Auth::user()->avatar }}" class="rounded-circle z-depth-0" alt="{{ Auth::user()->name }} {{ Auth::user()->lastname }}">
              @else
              <i class="fas fa-user-astronaut fa-lg"></i>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-default"
              aria-labelledby="navbarDropdownMenuLink-333">
              <a class="dropdown-item" href="{{ route('cogroupcms.usersprofile') }}">
                <i class="fa fa-user-circle"></i> {{ trans('moduleusers.profile') }}
              </a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt"></i> {{ __('cms.signout') }}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </a>
            </div>
          </li>
          @endauth
        </ul>

      </div>
      <!-- Collapsible content -->

    </div>

  </nav>
  <!--/.Navbar-->

</header>
<!--/.Double navigation-->