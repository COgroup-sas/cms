<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.cms_settings()->colortheme.'/logocms.png') : route('files.getFile', cms_settings()->logo) }}" alt="{{ cms_settings()->sitename }}" class="logo" alt="{{ cms_settings()->sitename }}">
</a>
</td>
</tr>
