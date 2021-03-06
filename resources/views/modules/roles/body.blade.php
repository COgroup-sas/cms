﻿@extends('cogroupcms::layouts.main')

@section('content')
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <h4 class="float-left">
          {{ mb_strtoupper(trans('moduleroles.title')) }}
          <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
        </h4>
        <div class="float-right">
          @if(cms_roles_check($user, 'roles', 'create') == true)
            <a id="add" href="{{ route('cogroupcms.roles.add') }}" class="btn btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleroles.add') }}">
              <i class="fas fa-plus-circle fa-lg"></i>
            </a>
          @endif
          @if(cms_roles_check($user, 'roles', 'update') == true)
            <a id="edit" href="{{ route('cogroupcms.roles.edit') }}" class="btn btnaction btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleroles.edit') }}">
              <i class="far fa-edit fa-lg"></i>
            </a>
          @endif
          @foreach(cms_get_modules('roles', 'N') as $mod)
            @if($user->roles_id == 1 || cms_roles_check($user, $mod['modulename'], 'view') == true)
            <a id="{{ mb_strtolower($mod['modulename']) }}" href="{{ route($mod['url']) }}" class="btn btnaction btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans($mod['modulename']) }}">
              <i class="{{ $mod['icon'] }} fa-lg"></i>
            </a>
            @endif
          @endforeach
        </div>
      </div>
      <div class="card-body">
        <form role="form" id="form_advanced_validation" class="masked-input form" method="POST" action="{{ route('cogroupcms.roles.home')."/" }}">
          {{ csrf_field() }}
          <table class="table table-bordered table-striped table-hover dataTableCog">
            <thead>
              <tr>
                <th class="text-center">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input allcheck" id="allchecktop">
                    <label class="custom-control-label" for="allchecktop"></label>
                  </div>
                </th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.name') }}</th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.description') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.created_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.updated_at') }}</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="text-center">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input allcheck" id="allcheckbottom">
                    <label class="custom-control-label" for="allcheckbottom"></label>
                  </div>
                </th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.name') }}</th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.description') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.created_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.updated_at') }}</th>
              </tr>
            </tfoot>
            <tbody>
            @foreach($roles as $rol)
              <tr>
                <th class="text-center">
                  @if(cms_roles_check($user, 'roles', 'update') == true || 
                  cms_roles_check($user, 'Permisos', 'update') == true)
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input check" id="chk_{{ $rol->id }}" name="id" value="{{ $rol->id }}">
                    <label class="custom-control-label" for="chk_{{ $rol->id }}"></label>
                  </div>
                  @endif
                </th>
                <td>{{ $rol->rolname }}</td>
                <td>{{ $rol->description }}</td>
                <td class="text-center">{{ cms_format_datetime($rol->created_at) }}</td>
                <td class="text-center">{{ cms_format_datetime($rol->updated_at) }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- #END# Basic Examples -->
<!-- Modal Permissions Error -->
<div class="modal fade" id="permisos-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleroles.modalerrorpermissions') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal more permissions Error -->
<div class="modal fade" id="more-permisos-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleroles.modalerrormorepermissions') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Error -->
<div class="modal fade" id="edit-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleroles.modalerroredit') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal More Edit Error -->
<div class="modal fade" id="more-edit-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleroles.modalerrormoreedit') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modals -->
@endsection