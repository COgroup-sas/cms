<footer class="footer">
  <div class="container">
    <div class="copyright">&copy; {{ date("Y") }} {{ trans('cms.rights') }}</div>
    <nav>
      <ul>
        <li><i class="fa fa-phone"></i> {{ $settings->phone }}</li>
        <li><i class="fa fa-map-marker"></i> {{ $settings->address }}</li>
        <li><i class="fa fa-envelope"></i> {{ $settings->emailaddress }}</li>
      </div>
    </nav>
  </div>
</footer>