@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => (request()->wantsJson()) ? config('cogroupcms.apiurl') : config('app.url')])
{{ cms_settings()->sitename }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ cms_settings()->sitename }}. @lang('cms.rights')
@endcomponent
@endslot
@endcomponent
