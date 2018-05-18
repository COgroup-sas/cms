@extends('cogroupcms::layouts.main')

@section('content')
  <section class="content">
    <div class="container-fluid">
       <!-- Input -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h2>
                  {{ trans('moduleroles.permissions') }}
                  <small>
                    {{ $rolpermissions->rolname }}
                  </small>
              </h2>
            </div>
            <div class="card-body">
              {{ csrf_field() }}
              @foreach($modulesrol as $module)
              <input type="hidden" id="rolurl" value="{{ route('cogroupcms.rolsetpermission') }}">
              <div class="demo-switch">
                <div class="row clearfix">
                  <div class="col-sm-12">
                    <h4>{{ trans($module->modulename) }}</h4>
                    <div class="row">
                    @foreach(explode(",", $module->permissions) as $perm)
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="switch-sm" data-id="{{ $module->id }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm">
                            <input type="checkbox" name="checkbox" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"<?php
                              echo (Cogroup\Cms\Http\Controllers\CmsController::checkPermission($rolpermissions, $module->moduleslug, $perm)) ? ' checked' : '';
                              ?> id="{{ $module->id.'-'.$perm }}"> {{ trans('cms.txt'.$perm) }}
                          </label>
                        </div>
                      </div>
                    @endforeach
                    </div>
                    @if(!empty($module->submod) and count($module->submod) > 0)
                      @foreach($module->submod as $submod)
                    <h5><i class="fas fa-long-arrow-alt-right"></i> {{ trans($submod->modulename) }}</h5>
                    <div class="row">
                        @foreach(explode(",", $submod->permissions) as $perm)
                      <div class="col-sm-2">
                        <div class="form-group">  
                          <span class="switch switch-sm">
                            <label for="switch-sm" data-id="{{ $submod->id }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm">
                              <input type="checkbox" name="checkbox" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"<?php
                            echo (Cogroup\Cms\Http\Controllers\CmsController::checkPermission($rolpermissions, $submod->moduleslug, $perm)) ? ' checked' : '';
                          ?> class="switch" id="{{ $submod->id.'-'.$perm }}">
                              {{ trans('cms.txt'.$perm) }}
                            </label>
                          </span>
                        </div>
                      </div>
                        @endforeach
                    </div>
                        @if(count($submod->submod) > 0)
                          @foreach($submod->submod as $ssubmod)
                    <h5><i class="material-icons">remove</i><i class="fas fa-minus"></i> {{ trans($ssubmod->modulename) }}</h5>
                    <div class="row">
                          @foreach(explode(",", $ssubmod->permissions) as $perm)
                      <div class="col-sm-2">
                        <div class="switch">
                          {{ trans('cms.txt'.$perm) }}
                          <label>
                            <input type="checkbox" name="checkbox" class="bootstrap-switch" data-on-label="<i class='now-ui-icons ui-1_check'></i>" data-off-label="<i class='now-ui-icons ui-1_simple-remove'></i>"<?php
                              echo (Cogroup\Cms\Http\Controllers\CmsController::checkPermission($rolpermissions, $ssubmod->moduleslug, $perm)) ? ' checked' : '';
                            ?> data-id="{{ $ssubmod->id }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm">
                            {{ trans('cms.txt'.$perm) }}
                        </label>
                        </div>
                      </div>
                            @endforeach
                    </div>

                            @if(count($ssubmod->submod) > 0)
                              @foreach($ssubmod->submod as $sssubmod)
                        <h5><i class="material-icons">remove</i><i class="fas fa-minus"></i> {{ trans($sssubmod->modulename) }}</h5>
                        <div class="row">
                              @foreach(explode(",", $sssubmod->permissions) as $perm)
                          <div class="col-sm-2">
                            <div class="switch">
                              {{ trans('cms.txt'.$perm) }}
                              <label><input type="checkbox"<?php
                                echo (Cogroup\Cms\Http\Controllers\CmsController::checkPermission($rolpermissions, $sssubmod->moduleslug, $perm)) ? ' checked' : '';
                              ?> data-id="{{ $ssubmod->id }}" data-perm="{{ $perm }}" data-rol-id="{{ $rolpermissions->id }}" class="perm"><span class="lever switch-col-red"></span></label>
                            </div>
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
    </div>
  </section>
@endsection
