@extends('admin.layouts.main')

@section('content')<section class="content">
    <div class="container-fluid">
      <!-- Basic Examples -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h2 class="float-left">
                {{ mb_strtoupper(trans('modules.users')) }}
                <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
              </h2>
              <div class="float-right">
                @if(App\Http\Controllers\CmsController::checkPermission($user, 'users', 'create') == true)
                  <a id="usersadd" href="{{ route('usersadd') }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.adduser') }}">
                    <i class="fas fa-plus-circle fa-2x"></i>
                  </a>
                @endif
                @if(App\Http\Controllers\CmsController::checkPermission($user, 'users', 'update') == true)
                  <a id="usersedit" href="{{ route('usersedit') }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.edituser') }}">
                    <i class="far fa-edit fa-2x"></i>
                  </a>
                @endif
                @foreach(App\Http\Controllers\CmsController::getModules('Usuarios', 'N') as $mod)
                  @if(App\Http\Controllers\CmsController::checkPermission($user, $mod->modulename, 'view') == true)
                  <a id="{{ $mod->modulename }}" href="{{ $mod->url }}" class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('modules.'.$mod->modulename) }}">
                    <i class="{{ $mod->icon }} fa-2x"></i>
                  </a>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="body table-responsive">
              <form role="form" id="form_advanced_validation" class="masked-input usersform" method="POST" action="{{ route('usershome')."/" }}">
                {{ csrf_field() }}
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                    <tr>
                      <th>
                        <input type="checkbox" id="select_all" class="">
                        <label for="select_all"></label>
                      </th>
                      <th>{{ trans('moduleusers.name') }}</th>
                      <th>{{ trans('cms.email') }}</th>
                      <th>cliente</th>
                      <th>{{ trans('moduleusers.rol') }}</th>
                      <th>{{ trans('cms.active') }}</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>
                        <input type="checkbox" id="select_all2" class="">
                        <label for="select_all2"></label>
                      </th>
                      <th>{{ trans('moduleusers.name') }}</th>
                      <th>{{ trans('cms.email') }}</th>
                      <th>cliente</th>
                      <th>{{ trans('moduleusers.rol') }}</th>
                      <th>{{ trans('cms.active') }}</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach($users as $usr)
                    <tr>
                      <th>
                        @if($usr->roles_id != 1)
                        <input type="checkbox" id="chk_{{ $usr->id }}" class=" check-usr" name="id" value="{{ $usr->id }}">
                        <label for="chk_{{ $usr->id }}"></label>
                        @endif
                      </th>
                      <td>{{ $usr->name }} {{ $usr->lastname }}</td>
                      <td>{{ $usr->email }}</td>
                      <td>{{ $usr->clients->name }}</td>
                      <td>{{ $usr->roles->rolname }}</td>
                      <td>
                        @if($usr->id != $user->id and ( $user->roles_id == 1 || App\Http\Controllers\CmsController::checkPermission($user, 'Usuarios', 'update') == true) )
                        <a class="user-active" data-id="{{ $usr->id }}" data-active="{{ $usr->active }}" href="{{ route('usersactive') }}">
                          <i class="{{ ($usr->active == 'Y') ? 'far fa-check-circle' : 'far fa-circle' }}"></i>
                        </a>
                        @else
                        <i class="material-icons">
                          {{ ($usr->active == "Y") ? 'done' : 'highlight_off' }}
                        </i>
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
    </div>
  </section>
@endsection