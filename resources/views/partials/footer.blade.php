<footer class="footer fixed-bottom text-center">
  <div class="container p-3">
    <div class="row">
      <div class="col-12 col-sm-3">&copy; {{ date("Y") }} {{ trans('cms.rights') }}</div>
      <div class="col-12 col-sm-9">
        <div class="row">
          <div class="col-12 col-sm-4"><i class="fa fa-phone"></i> {{ cms_settings()->phone }}</div>
          <div class="col-12 col-sm-4"><i class="fa fa-map-marker"></i> {{ cms_settings()->address }}</div>
          <div class="col-12 col-sm-4"><i class="fa fa-envelope"></i> {{ cms_settings()->emailaddress }}</div>
        </div>
      </div>
    </div>
  </div>
</footer>