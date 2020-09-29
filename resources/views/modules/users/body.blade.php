@extends('cogroupcms::layouts.main')

@section('content')<section class="content">
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <h4 class="float-left">
          {{ mb_strtoupper($title) }}
          <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
        </h4>
        <div class="float-right">
          @if(cms_roles_check($user, 'users', 'create') == true)
            <a id="add" href="{{ route('cogroupcms.users.add') }}" class="btn btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleusers.add') }}">
              <i class="fas fa-plus-circle fa-lg"></i>
            </a>
          @endif
          @if(cms_roles_check($user, 'users', 'update') == true)
            <a id="edit" href="{{ route('cogroupcms.users.edit') }}" class="btn btnaction btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleusers.edit') }}">
              <i class="far fa-edit fa-lg"></i>
            </a>
          @endif
          @foreach(cms_get_modules('Usuarios', 'N') as $mod)
            @if(cms_roles_check($user, $mod->modulename, 'view') == true)
            <a id="{{ $mod->modulename }}" href="{{ $mod->url }}" class="btn btnaction btn-round btn-blue-grey btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.'.$mod->modulename) }}">
              <i class="{{ $mod->icon }} fa-lg"></i>
            </a>
            @endif
          @endforeach
        </div>
      </div>
      <div class="card-body">
        <form role="form" id="form_advanced_validation" class="masked-input form" method="POST" action="{{ route('cogroupcms.users.home')."/" }}">
          {{ csrf_field() }}
          <table class="table table-bordered table-striped table-hover js-basic dataTableCog">
            <thead>
              <tr>
                <th class="text-center">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input allcheck" id="allchecktop">
                    <label class="custom-control-label" for="allchecktop"></label>
                  </div>
                </th>
                <th class="text-center font-weight-bold">{{ trans('moduleusers.name') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.email') }}</th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.rol') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.created_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.updated_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.active') }}</th>
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
                <th class="text-center font-weight-bold">{{ trans('moduleusers.name') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.email') }}</th>
                <th class="text-center font-weight-bold">{{ trans('moduleroles.rol') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.created_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.updated_at') }}</th>
                <th class="text-center font-weight-bold">{{ trans('cms.active') }}</th>
              </tr>
            </tfoot>
            <tbody>
            @foreach($users as $usr)
              <tr>
                <th class="text-center">
                  @if(cms_roles_check($user, 'users', 'update') == true)
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input check" id="chk_{{ $usr->id }}" name="id" value="{{ $usr->id }}">
                    <label class="custom-control-label" for="chk_{{ $usr->id }}"></label>
                  </div>
                  @endif
                </th>
                <td>{{ $usr->name }} {{ $usr->lastname }}</td>
                <td>{{ $usr->email }}</td>
                <td>{{ $usr->roles->rolname }}</td>
                <td class="text-center">{{ cms_format_datetime($usr->created_at) }}</td>
                <td class="text-center">{{ cms_format_datetime($usr->updated_at) }}</td>
                <td class="text-center">
                  @if(cms_roles_check($user, 'users', 'update') == true)
                  <a class="user-active" data-id="{{ $usr->id }}" data-active="{{ $usr->active }}" href="{{ route('cogroupcms.users.active') }}">
                    <i class="{{ ($usr->active == 'Y') ? 'far fa-check-circle' : 'far fa-circle' }}"></i>
                  </a>
                  @else
                  <i class="{{ ($usr->active == 'Y') ? 'far fa-check-circle' : 'far fa-circle' }}"></i>
                  @endif
                </td>
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
<div class="modal fade" id="permissions-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleusers.modalerrorpermissions') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal more permissions Error -->
<div class="modal fade" id="more-permissions-modal-error" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger text-white">
      <div class="modal-header">
        <h4 class="modal-title" id="defaultModalLabel">{{ trans('cms.modaltitleerror') }}</h4>
      </div>
      <div class="modal-body">{{ trans('moduleusers.modalerrormorepermissions') }}</div>
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
      <div class="modal-body">{{ trans('moduleusers.modalerroredit') }}</div>
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
      <div class="modal-body">{{ trans('moduleusers.modalerrormoreedit') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">{{ trans('cms.txtbtnclose') }}</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modals -->
@endsection