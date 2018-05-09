@extends('admin.layouts.main')

@section('content')
  <section class="content">
    <div class="container-fluid">
      <!-- Basic Examples -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h2 class="float-left">
                {{ mb_strtoupper(trans('modules.roles')) }}
                <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
              </h2>
              <div class="float-right">
                @if(App\Http\Controllers\CmsController::checkPermission($user, 'roles', 'create') == true)
                  <a id="rolesadd" href="{{ route('roladd') }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.addrol') }}">
                    <i class="fas fa-plus-circle fa-2x"></i>
                  </a>
                @endif
                @if(App\Http\Controllers\CmsController::checkPermission($user, 'roles', 'update') == true)
                  <a id="rolesedit" href="{{ route('roledit') }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.editrol') }}">
                    <i class="far fa-edit fa-2x"></i>
                  </a>
                @endif
                @foreach(App\Http\Controllers\CmsController::getModules('roles', 'N') as $mod)
                  @if($user->roles_id == 1 || App\Http\Controllers\CmsController::checkPermission($user, $mod->modulename, 'view') == true)
                  <a id="{{ mb_strtolower($mod->modulename) }}" href="{{ URL::to($mod->url) }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans($mod->modulename) }}">
                    <i class="{{ $mod->icon }} fa-2x"></i>
                  </a>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="card-body">
              <form role="form" id="form_advanced_validation" class="masked-input rolesform" method="POST" action="{{ route('roleshome')."/" }}">
                {{ csrf_field() }}
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>
                        <input type="checkbox" id="select_all" class="">
                        <label for="select_all"></label>
                      </th>
                      <th>{{ trans('moduleroles.name') }}</th>
                      <th>{{ trans('moduleroles.description') }}</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>
                        <input type="checkbox" id="select_all2" class="">
                        <label for="select_all2"></label>
                      </th>
                      <th>{{ trans('moduleroles.name') }}</th>
                      <th>{{ trans('moduleroles.description') }}</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach($roles as $rol)
                    <tr>
                      <th>
                        @if(App\Http\Controllers\CmsController::checkPermission($user, 'roles', 'update') == true || 
                        App\Http\Controllers\CmsController::checkPermission($user, 'Permisos', 'update') == true)
                        <input type="checkbox" id="chk_{{ $rol->id }}" class=" check-rol" name="id" value="{{ $rol->id }}">
                        <label for="chk_{{ $rol->id }}"></label>
                        @endif
                      </th>
                      <td>{{ $rol->rolname }}</td>
                      <td>{{ $rol->description }}</td>
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
    </div>
  </section>
@endsection