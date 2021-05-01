@extends('cogroupcms::layouts.main')

@section('content')
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-5 pb-4">
    <div class="card">
      <div class="card-header">
        <h4>
          {{ trans('moduleroles.permissions') }}
          <small>
            {{ $rolpermissions->rolname }}
          </small>
        </h4>
      </div>
      <div class="card-body">
        {{ csrf_field() }}
        @foreach($modulesrol as $module)
        <input type="hidden" id="rolurl" value="{{ route('cogroupcms.roles.setpermission') }}">
        <div class="demo-switch">
          <div class="row clearfix">
            <div class="col-sm-12">
              <h4>{{ trans($module['modulename']) }}</h4>
              <div class="row">
              @foreach(explode(",", $module['permissions']) as $perm)
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="material-switch">
                      <input id="{{ $module['id'] }}-{{ $perm }}" name="{{ $module['id'] }}-{{ $perm }}" type="checkbox" data-id="{{ $module['id'] }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm" <?php
                        echo (cms_roles_check($rolpermissions, $module['moduleslug'], $perm)) ? ' checked' : '';
                        ?> id="{{ $module['id'].'-'.$perm }}">
                      <label for="{{ $module['id'] }}-{{ $perm }}" class="default-color" data-background-color="{{ cms_settings()->colortheme }}"></label>
                    </div> {{ trans('cms.txt'.$perm) }}
                  </div>
                </div>
              @endforeach
              </div>
              @if(!empty($module['submod']) and count($module['submod']) > 0)
                @foreach($module['submod'] as $submod)
              <h5><i class="fas fa-long-arrow-alt-right"></i> {{ trans($submod['modulename']) }}</h5>
              <div class="row">
                  @foreach(explode(",", $submod['permissions']) as $perm)
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="material-switch">
                      <input id="{{ $submod['id'] }}-{{ $perm }}" name="{{ $submod['id'] }}-{{ $perm }}" type="checkbox" data-id="{{ $submod['id'] }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm" <?php
                        echo (cms_roles_check($rolpermissions, $submod['moduleslug'], $perm)) ? ' checked' : '';
                        ?> id="{{ $module['id'].'-'.$perm }}">
                      <label for="{{ $submod['id'] }}-{{ $perm }}" class="default-color" data-background-color="{{ cms_settings()->colortheme }}"></label>
                    </div> {{ trans('cms.txt'.$perm) }}
                  </div>
                </div>
                  @endforeach
              </div>
                  @if(count($submod['submod']) > 0)
                    @foreach($submod['submod'] as $ssubmod)
              <h5><i class="fas fa-minus"></i><i class="fas fa-long-arrow-alt-right"></i> {{ trans($ssubmod['modulename']) }}</h5>
              <div class="row">
                    @foreach(explode(",", $ssubmod['permissions']) as $perm)
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="material-switch">
                      <input id="{{ $ssubmod['id'] }}-{{ $perm }}" name="{{ $ssubmod['id'] }}-{{ $perm }}" type="checkbox" data-id="$ssubmod['id']" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm" <?php
                        echo (cms_roles_check($rolpermissions, $ssubmod['moduleslug'], $perm)) ? ' checked' : '';
                        ?> id="{{ $module['id'].'-'.$perm }}">
                      <label for="{{ $ssubmod['id'] }}-{{ $perm }}" class="default-color" data-background-color="{{ cms_settings()->colortheme }}"></label>
                    </div> {{ trans('cms.txt'.$perm) }}
                  </div>
                </div>
                      @endforeach
              </div>

                      @if(count($ssubmod['submod']) > 0)
                        @foreach($ssubmod['submod'] as $sssubmod)
                  <h5><i class="fas fa-minus"></i><i class="fas fa-minus"></i><i class="fas fa-long-arrow-alt-right"></i> {{ trans($ssubmod['modulename']) }}</h5>
                  <div class="row">
                        @foreach(explode(",", $sssubmod['permissions']) as $perm)
                    <div class="col-sm-3">
                      <div class="material-switch">
                        <input id="{{ $sssubmod['id'] }}-{{ $perm }}" name="{{ $sssubmod['id'] }}-{{ $perm }}" type="checkbox" data-id="$sssubmod['id']" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm" <?php
                          echo (cms_roles_check($rolpermissions, $sssubmod['moduleslug'], $perm)) ? ' checked' : '';
                          ?> id="{{ $module['id'].'-'.$perm }}">
                        <label for="{{ $sssubmod['id'] }}-{{ $perm }}" class="default-color" data-background-color="{{ cms_settings()->colortheme }}"></label>
                      </div> {{ trans('cms.txt'.$perm) }}
                    </div>
                          @endforeach
                  </div>
                        @endforeach
                      @endif

                    @endforeach
                  @endif
                @endforeach
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
