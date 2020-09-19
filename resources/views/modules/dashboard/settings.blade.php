@extends('cogroupcms::layouts.main')

@section('content')
  <form action="{{ route('cogroupcms.settings.save') }}" role="form" id="form_advanced_validation" class="masked-input no-gutters mb-5 pb-4" method="POST" autocomplete="off" enctype="multipart/form-data">
    {{ csrf_field() }}
        <!-- Contact data -->
        <div class="row clearfix mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.contact') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-row mb-3">
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
                <div class="form-row mb-3">
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
                <div class="form-row mb-3">
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
                <div class="form-row mb-3">
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
                <div class="form-row mb-3">
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
                  <button class="btn btn-theme waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Website data -->
        <div class="row clearfix mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.site.title') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-row mb-3">
                  <label class="col-sm-3 col-form-label">{!! trans('modulesettings.site.sitename') !!}</label>
                  <div class="col-sm-9">
                    <input required type="text" name="sitename" class="form-control" placeholder="{{ trans('modulesettings.site.sitename') }}" value="{{ (!empty(old('sitename'))) ? old('sitename') : cms_settings()->sitename }}" />
                    @if ($errors->has('sitename'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('sitename') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-3 col-form-label">{!! trans('modulesettings.site.sitedescription') !!}</label>
                  <div class="col-sm-9">
                    <textarea name="sitedescription" rows="4" class="form-control no-resize" placeholder="{{ trans('modulesettings.site.sitedescription') }}">{{ (!empty(old('sitedescription'))) ? old('sitedescription') : cms_settings()->sitedescription }}</textarea>
                    @if ($errors->has('sitedescription'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('sitedescription') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-3 col-form-label">{!! trans('modulesettings.site.sitekeywords') !!}</label>
                  <div class="col-sm-9">
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
                    <label class="col-form-label col-sm-3">{{ trans('modulesettings.site.timeformat') }}</label>
                    <div class="col-sm-9">
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="timeformat" name="timeformat" value="h:i a"@if(cms_settings()->timeformat == 'h:i a') checked @endif>
                        <label class="custom-control-label" for="timeformat">{{ date('h:i a') }}</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="timeformat" name="timeformat" value="h:i a"@if(cms_settings()->timeformat == 'h:i A') checked @endif>
                        <label class="custom-control-label" for="timeformat">{{ date('h:i A') }}</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="timeformat" name="timeformat" value="h:i a"@if(cms_settings()->timeformat == 'H:i') checked @endif>
                        <label class="custom-control-label" for="timeformat">{{ date('H:i') }}</label>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <fieldset class="form-group">
                  <div class="row">
                    <label class="col-form-label col-sm-3">{{ trans('modulesettings.site.dateformat') }}</label>
                    <div class="col-sm-9">
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dateformat" name="dateformat" value="Y-m-d"@if(cms_settings()->dateformat == 'Y-m-d') checked @endif>
                        <label class="custom-control-label" for="dateformat">{{ date('Y-m-d') }}</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dateformat" name="dateformat" value="F d, Y"@if(cms_settings()->dateformat == 'F d, Y') checked @endif>
                        <label class="custom-control-label" for="dateformat">{{ date('F d, Y') }}</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dateformat" name="dateformat" value="Y/m/d"@if(cms_settings()->dateformat == 'Y/m/d') checked @endif>
                        <label class="custom-control-label" for="dateformat">{{ date('Y/m/d') }}</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="dateformat" name="dateformat" value="d/m/y"@if(cms_settings()->dateformat == 'd/m/y') checked @endif>
                        <label class="custom-control-label" for="dateformat">{{ date('d/m/y') }}</label>
                      </div>
                    </div>
                  </div>
                </fieldset>
                <div class="form-row mb-3">
                  <label class="col-sm-3 col-form-label">{!! trans('modulesettings.site.analyticscode') !!}</label>
                  <div class="col-sm-9">
                    <textarea name="analyticscode" rows="4" class="form-control no-resize" placeholder="{{ trans('modulesettings.site.analyticscode') }}">{{ (!empty(old('analyticscode'))) ? old('analyticscode') : cms_settings()->analyticscode }}</textarea>
                    @if ($errors->has('analyticscode'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('analyticscode') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

                <div class="form-row mb-3">
                  <label class="col-sm-3 col-form-label">{!! trans('modulesettings.site.defaultrol') !!}</label>
                  <div class="col-sm-9">
                    <div class="form-line">
                      @foreach($roles as $rol)
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="{{ mb_strtolower($rol->rolname) }}" name="defaultrol" value="{{ $rol->id }}"@if(cms_settings()->defaultrol == $rol->id) checked @endif>
                        <label class="custom-control-label" for="{{ mb_strtolower($rol->rolname) }}">{{ $rol->rolname }}</label>
                      </div>
                      @endforeach
                      @if ($errors->has('defaultrol'))
                        <span class="form-text text-danger">
                          <strong>{{ $errors->first('defaultrol') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="text-right">
                  <button class="btn btn-theme waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Images -->
        <div class="row clearfix mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2>
                  {{ trans('modulesettings.image.title') }}
                </h2>
              </div>
              <div class="card-body">
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.image.favicon') !!}</label>
                  <div class="col-sm-7">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customFavicon" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="favicon">
                      <label class="custom-file-label" for="customFavicon">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                    @if ($errors->has('favicon'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('favicon') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-primary img-fluid rounded my-0 p-2" data-background-color="{{ config('cogroupcms.color_theme') }}">
                      <img class="rounded mx-auto d-block img-fluid" src="{{ (empty(cms_settings()->favicon)) ? asset('vendor/cogroup/cms/images/favicon.png') : route('files.getFile', cms_settings()->favicon) }}">
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.image.logo') !!}</label>
                  <div class="col-sm-7">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customLogo" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="logo">
                      <label class="custom-file-label" for="customLogo">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                    @if ($errors->has('logo'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('logo') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-3">
                    <div class="img-fluid rounded my-0 p-2">
                      <img class="rounded mx-auto d-block img-fluid" src="{{ (empty(cms_settings()->logo)) ? asset('vendor/cogroup/cms/images/'.config('cogroupcms.color_theme', 'orange').'/logocms.png') : route('files.getFile', cms_settings()->logo) }}">
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.image.logocontraste') !!}</label>
                  <div class="col-sm-7">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customLogocontraste" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="logocontraste">
                      <label class="custom-file-label" for="customLogocontraste">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                    @if ($errors->has('logocontraste'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('logocontraste') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-primary img-fluid rounded my-0 p-2" data-background-color="{{ config('cogroupcms.color_theme') }}">
                      <img class="rounded mx-auto d-block img-fluid" src="{{ (empty(cms_settings()->logocontraste)) ? asset('vendor/cogroup/cms/images/logocmscontraste.png') : route('files.getFile', cms_settings()->logocontraste) }}">
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <button class="btn btn-theme waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
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
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.access') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <div class="material-switch">
                        <input name="socialaccess" type="checkbox" value="1" {{ (cms_settings()->socialaccess == 1) ? 'checked' : '' }} id="socialaccess">
                        <label for="socialaccess" class="default-color" data-background-color="{{ config('cogroupcms.color_theme') }}"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.gmail') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <div class="material-switch">
                        <input name="socialaccessgoogle" type="checkbox" value="1" {{ (cms_settings()->socialaccessgoogle == 1) ? 'checked' : '' }} id="socialaccessgoogle">
                        <label for="socialaccessgoogle" class="default-color" data-background-color="{{ config('cogroupcms.color_theme') }}"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.facebook') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <div class="material-switch">
                        <input name="socialaccessfacebook" type="checkbox" value="1" {{ (cms_settings()->socialaccessfacebook == 1) ? 'checked' : '' }} id="socialaccessfacebook">
                        <label for="socialaccessfacebook" class="default-color" data-background-color="{{ config('cogroupcms.color_theme') }}"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">{!! trans('modulesettings.social.twitter') !!}</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <div class="material-switch">
                        <input name="socialaccesstwitter" type="checkbox" value="1" {{ (cms_settings()->socialaccesstwitter == 1) ? 'checked' : '' }} id="socialaccesstwitter">
                        <label for="socialaccesstwitter" class="default-color" data-background-color="{{ config('cogroupcms.color_theme') }}"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row mb-3">
                  <label class="col-sm-2 col-form-label">Linkedin</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <div class="material-switch">
                        <input name="socialaccesslinkedin" type="checkbox" value="1" {{ (cms_settings()->socialaccesslinkedin == 1) ? 'checked' : '' }} id="socialaccesslinkedin">
                        <label for="socialaccesslinkedin" class="default-color" data-background-color="{{ config('cogroupcms.color_theme') }}"></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <button class="btn btn-theme waves-effect" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
  </form>
@endsection