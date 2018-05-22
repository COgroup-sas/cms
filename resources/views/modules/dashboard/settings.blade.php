@extends('cogroupcms::layouts.main')

@section('content')
  <form action="{{ route('cogroupcms.settingsave') }}" role="form" id="form_advanced_validation" class="masked-input" method="POST" autocomplete="off" enctype="multipart/form-data">
    {{ csrf_field() }}
    <section class="content">
      <div class="container-fluid">
        <!-- Basic Examples -->
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
                  <button class="btn btn-primary waves-effect" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
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
                  <button class="btn btn-primary waves-effect" type="submit">{{ trans('cms.txtbtnaccept') }}</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>
@endsection