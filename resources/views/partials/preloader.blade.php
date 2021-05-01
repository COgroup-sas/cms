<div class="preloader">
	<div class="loader" data-color="{{ cms_settings()->colortheme }}">
		<img class="rounded-circle" src="{{ (empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('files.getFile', cms_settings()->favicon) }}">
	</div>
</div>