<div class="preloader">
	<div class="loader">
		<img class="rounded-circle" src="{{ (empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('getFile', cms_settings()->favicon) }}">
	</div>
</div>