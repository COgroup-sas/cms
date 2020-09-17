@extends('cogroupcms::layouts.main')

@section('content')
<section class="content">
    <div class="container-fluid">
      <!-- Input -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-5 pb-4">
          <div class="card">
            <div class="card-header">
              <h2>
                @if(isset($useredit))
                {{ trans('moduleusers.edit') }}
                @else
                {{ trans('moduleusers.add') }}
                @endif
                <small>{{ trans('moduleusers.basicinformation') }}</small>
              </h2>
            </div>
            <div class="card-body">
              <form role="form" id="form_advanced_validation" class="masked-input needs-validation" method="POST" action="{{ route('cogroupcms.userspost') }}" novalidate="novalidate">
                {{ csrf_field() }}
                @if(isset($useredit))
                <input name="id" type="hidden" value="{{ $useredit->id }}" />
                @endif
                <label for="name">{{ trans('moduleusers.name') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input required name="name" type="text" class="form-control" placeholder="{{ trans('moduleusers.name') }}" value="{{ (!isset($useredit)) ? old('name') : $useredit->name }}" />
                    @if ($errors->has('name'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="name">{{ trans('moduleusers.lastname') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input required name="lastname" type="text" class="form-control" placeholder="{{ trans('moduleusers.lastname') }}" value="{{ (!isset($useredit)) ? old('lastname') : $useredit->lastname }}" />
                    @if ($errors->has('lastname'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('lastname') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="email">{{ trans('cms.email') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input required name="email" type="email" class="form-control" placeholder="{{ trans('cms.email') }}" value="{{ (!isset($useredit)) ? old('email') : $useredit->email }}" />
                    @if ($errors->has('email'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="password}">{{ trans('moduleusers.password') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input @if(!isset($useredit))
                    required 
                    @endif
                    type="password" name="password" class="form-control" placeholder="{{ trans('moduleusers.password') }}" />
                    @if ($errors->has('password'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="confirmpassword">{{ trans('moduleusers.confirmpassword') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input @if(!isset($useredit))
                    required 
                    @endif
                    type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('moduleusers.confirmpassword') }}" />
                    @if ($errors->has('password_confirmation'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="roles_id">{{ trans('moduleroles.rol') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    @foreach($roles as $rol)
                      <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input check" id="chk_{{ $rol->id }}" name="roles_id" value="{{ $rol->id }}"{{ ((isset($useredit) and $rol->id == $useredit->roles_id) || old('roles_id') == $rol->id) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="chk_{{ $rol->id }}">{{ $rol->rolname }}</label>
                      </div>
                    @endforeach
                    @if ($errors->has('roles_id'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('roles_id') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-6 text-right">
                    <a class="btn btn-danger waves-effect" href="{{ route('cogroupcms.usershome') }}">{{ trans('cms.txtbtncancel') }} <i class="fas fa-ban"></i></a>
                  </div>
                  <div class="col-6 text-left">
                    <button class="btn btn-success waves-effect" type="submit">{{ trans('cms.textbtnsubmit') }} <i class="fa fa-cloud"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
