@extends('cogroupcms::layouts.main')

@section('content')
  <section class="content">
    <div class="container-fluid">
      <!-- Basic Examples -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h2 class="float-left">
                {{ mb_strtoupper(trans('moduleroles.title')) }}
                <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
              </h2>
              <div class="float-right">
                @if(cms_roles_check($user, 'roles', 'create') == true)
                  <a id="add" href="{{ route('cogroupcms.roladd') }}" class="btn btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleroles.add') }}">
                    <i class="fas fa-plus-circle"></i>
                  </a>
                @endif
                @if(cms_roles_check($user, 'roles', 'update') == true)
                  <a id="edit" href="{{ route('cogroupcms.roledit') }}" class="btn btnaction btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="tooltip" data-placement="top" title="{{ trans('moduleroles.edit') }}">
                    <i class="far fa-edit"></i>
                  </a>
                @endif
                @foreach(cms_get_modules('roles', 'N') as $mod)
                  @if($user->roles_id == 1 || cms_roles_check($user, $mod->modulename, 'view') == true)
                  <a id="{{ mb_strtolower($mod->modulename) }}" href="{{ URL::to($mod->url) }}" class="btn btnaction btn-round btn-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="tooltip" data-placement="top" title="{{ trans($mod->modulename) }}">
                    <i class="{{ $mod->icon }}"></i>
                  </a>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="card-body">
              <form role="form" id="form_advanced_validation" class="masked-input form" method="POST" action="{{ route('cogroupcms.roleshome')."/" }}">
                {{ csrf_field() }}
                <table class="table table-bordered table-striped table-hover js-basic dataTable">
                  <thead>
                    <tr>
                      <th>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input allcheck">
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                        <label for="select_all"></label>
                      </th>
                      <th>{{ trans('moduleroles.name') }}</th>
                      <th>{{ trans('moduleroles.description') }}</th>
                      <th>{{ trans('cms.created_at') }}</th>
                      <th>{{ trans('cms.updated_at') }}</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input allcheck">
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                      </th>
                      <th>{{ trans('moduleroles.name') }}</th>
                      <th>{{ trans('moduleroles.description') }}</th>
                      <th>{{ trans('cms.created_at') }}</th>
                      <th>{{ trans('cms.updated_at') }}</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach($roles as $rol)
                    <tr>
                      <th>
                        @if(cms_roles_check($user, 'roles', 'update') == true || 
                        cms_roles_check($user, 'Permisos', 'update') == true)
                        <div class="form-check">
                          <label class="form-check-label" for="chk_{{ $rol->id }}">
                            <input type="checkbox" class="form-check-input check" id="chk_{{ $rol->id }}" name="id" value="{{ $rol->id }}">
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                        @endif
                      </th>
                      <td>{{ $rol->rolname }}</td>
                      <td>{{ $rol->description }}</td>
                      <td>{{ cms_format_datetime($rol->created_at) }}</td>
                      <td>{{ cms_format_datetime($rol->updated_at) }}</td>
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