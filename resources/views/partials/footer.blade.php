<footer class="footer">
  <div class="container">
    <div class="copyright">&copy; {{ date("Y") }} {{ trans('cms.rights') }}</div>
    <nav>
      <ul>
        <li><i class="fa fa-phone"></i> {{ cms_settings()->phone }}</li>
        <li><i class="fa fa-map-marker"></i> {{ cms_settings()->address }}</li>
        <li><i class="fa fa-envelope"></i> {{ cms_settings()->emailaddress }}</li>
      </div>
    </nav>
  </div>
</footer>