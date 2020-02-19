@extends('cogroupcms::layouts.main')

@section('content')
  <form action="{{ route('cogroupcms.settingsave') }}" role="form" id="form_advanced_validation" class="masked-input no-gutters" method="POST" autocomplete="off" enctype="multipart/form-data">
    {{ csrf_field() }}
        <!-- Contact data -->
        <div class="row clearfix">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.contact') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label for="address" class="col-sm-2 col-form-label">{{ trans('modulesettings.address') }}</label>
                  <div class="col-sm-10">
                    <input required type="text" name="address" class="form-control" placeholder="{{ trans('modulesettings.address') }}" value="{{ (!empty(old('address'))) ? old('address') : cms_settings()->address }}" />
                    @if ($errors->has('address'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('address') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{ trans('modulesettings.phone') }}</label>
                  <div class="col-sm-10">
                    <input required type="phone" name="phone" class="form-control phone-number" placeholder="{{ trans('modulesettings.phone') }}" value="{{ (!empty(old('phone'))) ? old('phone') : cms_settings()->phone }}" />
                    @if ($errors->has('phone'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('phone') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{ trans('modulesettings.mobilephone') }}</label>
                  <div class="col-sm-10">
                    <input required type="phone" name="mobile" class="form-control mobile-phone-number" placeholder="{{ trans('modulesettings.mobilephone') }}" value="{{ (!empty(old('mobile'))) ? old('mobile') : cms_settings()->mobile }}" />
                    @if ($errors->has('mobile'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('mobile') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{ trans('modulesettings.emailname') }}</label>
                  <div class="col-sm-10">
                    <input required type="text" name="emailname" class="form-control" placeholder="{{ trans('modulesettings.emailcontact') }}" value="{{ (!empty(old('emailname'))) ? old('emailname') : cms_settings()->emailname }}" />
                    @if ($errors->has('emailname'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('emailname') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{{ trans('modulesettings.emailcontact') }}</label>
                  <div class="col-sm-10">
                    <input required type="email" name="emailaddress" class="form-control" placeholder="{{ trans('modulesettings.emailcontact') }}" value="{{ (!empty(old('emailaddress'))) ? old('emailaddress') : cms_settings()->emailaddress }}" />
                    @if ($errors->has('emailaddress'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('emailaddress') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="text-right">
                  <button class="btn btn-primary waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <!-- Website data -->
        <div class="row clearfix">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.site.title') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.site.sitename') !!}</label>
                  <div class="col-sm-10">
                    <input required type="text" name="sitename" class="form-control" placeholder="{{ trans('modulesettings.site.sitename') }}" value="{{ (!empty(old('sitename'))) ? old('sitename') : cms_settings()->sitename }}" />
                    @if ($errors->has('sitename'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('sitename') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.site.sitedescription') !!}</label>
                  <div class="col-sm-10">
                    <textarea name="sitedescription" rows="4" class="form-control no-resize" placeholder="{{ trans('modulesettings.site.sitedescription') }}">{{ (!empty(old('sitedescription'))) ? old('sitedescription') : cms_settings()->sitedescription }}</textarea>
                    @if ($errors->has('sitedescription'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('sitedescription') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.site.sitekeywords') !!}</label>
                  <div class="col-sm-10">
                    <textarea name="sitekeywords" rows="4" class="form-control no-resize" placeholder="{{ trans('modulesettings.site.sitekeywords') }}">{{ (!empty(old('sitekeywords'))) ? old('sitekeywords') : cms_settings()->sitekeywords }}</textarea>
                    @if ($errors->has('sitekeywords'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('sitekeywords') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <fieldset class="form-group">
                  <div class="row">
                    <label class="col-form-label col-sm-2">{{ trans('modulesettings.site.timeformat') }}</label>
                    <div class="col-sm-10">
                      <div class="form-check form-check-radio">
                        <label class="form-check-label" for="radio1">
                          <input id="radio1" type="radio" name="timeformat" class="form-check-input" value="h:i a"@if(cms_settings()->timeformat == 'h:i a') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('h:i a') }}
                        </label>
                      </div>
                      <div class="form-check form-check-radio">
                        <label class="form-check-label" for="radio2">
                          <input id="radio2" type="radio" name="timeformat" class="form-check-input" value="h:i A"@if(cms_settings()->timeformat == 'h:i A') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('h:i A') }}
                        </label>
                      </div>
                      <div class="form-check form-check-radio">
                        <label class="form-check-label" for="radio2">
                          <input id="radio3" type="radio" name="timeformat" class="form-check-input" value="H:I"@if(cms_settings()->timeformat == 'H:i') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('H:i') }}
                        </label>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <fieldset class="form-group">
                  <div class="row">
                    <label class="col-form-label col-sm-2">{{ trans('modulesettings.site.dateformat') }}</label>
                    <div class="col-sm-10">
                      <div class="form-check form-check-radio">
                        <label class="form-check-label">
                          <input id="radio4" type="radio" name="dateformat" class="form-check-input" value="Y-m-d"@if(cms_settings()->dateformat == 'Y-m-d') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('Y-m-d') }}
                        </label>
                      </div>
                      <div class="form-check form-check-radio">
                        <label class="form-check-label">
                          <input id="radio5" type="radio" name="dateformat" class="form-check-input" value="F d, Y"@if(cms_settings()->dateformat == 'F d, Y') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('F d, Y') }}
                        </label>
                      </div>
                      <div class="form-check form-check-radio">
                        <label class="form-check-label">
                          <input id="radio6" type="radio" name="dateformat" class="form-check-input" value="Y/m/d"@if(cms_settings()->dateformat == 'Y/m/d') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('Y/m/d') }}
                        </label>
                      </div>
                      <div class="form-check form-check-radio">
                        <label class="form-check-label">
                          <input id="radio7" type="radio" name="dateformat" class="form-check-input" value="d/m/y"@if(cms_settings()->dateformat == 'd/m/y') checked @endif />
                          <span class="form-check-sign"></span>
                          {{ date('d/m/y') }}
                      </label>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <div class="text-right">
                  <button class="btn btn-primary waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <!-- Images -->
        <div class="row clearfix">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.image.title') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.image.favicon') !!}</label>
                  <div class="col-sm-7">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customFile" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="favicon">
                      <label class="custom-file-label" for="customFile">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                    @if ($errors->has('favicon'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('favicon') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-primary img-fluid rounded my-0 p-2" data-background-color="{{ config('cogroupcms.color_theme') }}">
                      <img class="rounded mx-auto d-block" src="{{ (empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('getFile', cms_settings()->favicon) }}">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.image.logo') !!}</label>
                  <div class="col-sm-7">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customFile" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="logo">
                      <label class="custom-file-label" for="customFile">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                    @if ($errors->has('logo'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('logo') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-primary img-fluid rounded my-0 p-2" data-background-color="{{ config('cogroupcms.color_theme') }}">
                      <img class="rounded mx-auto d-block" src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'light-blue').'/logocms.png') : route('getFile', cms_settings()->logo) }}">
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <button class="btn btn-primary waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Social access -->
        <div class="row clearfix">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.social.title') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.access') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <label for="switch-sm">
                        <input type="checkbox" name="socialaccess" value="1" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"@if(cms_settings()->socialaccess == 1){{ ' checked' }}@endif id="socialaccess">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.gmail') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <label for="switch-sm">
                        <input type="checkbox" name="socialaccessgoogle" value="1" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"@if(cms_settings()->socialaccessgoogle == 1){{ ' checked' }}@endif id="socialaccessgoogle">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.facebook') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <label for="switch-sm">
                        <input type="checkbox" name="socialaccessfacebook" value="1" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"@if(cms_settings()->socialaccessfacebook == 1){{ ' checked' }}@endif id="socialaccessfacebook">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.twitter') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <label for="switch-sm">
                        <input type="checkbox" name="socialaccesstwitter" value="1" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"@if(cms_settings()->socialaccesstwitter == 1){{ ' checked' }}@endif id="socialaccesstwitter">
                      </label>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <button class="btn btn-primary waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
  </form>
@endsection