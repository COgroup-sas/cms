@extends('cogroupcms::layouts.main')

@section('content')
<div class="row clearfix">
  <div class="col-12">
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
        <form role="form" id="form_advanced_validation" class="masked-input needs-validation" method="POST" action="{{ route('cogroupcms.users.save') }}" novalidate="novalidate">
          {{ csrf_field() }}
          @if(isset($useredit))
          <input name="id" type="hidden" value="{{ $useredit->id }}" />
          @endif
          <div class="md-form">
            <input required name="name" type="text" class="form-control" value="{{ (!isset($useredit)) ? old('name') : $useredit->name }}" /><label for="name">{{ trans('moduleusers.name') }}</label>
            @if ($errors->has('name'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>
          <div class="md-form">
            <input required name="lastname" type="text" class="form-control" value="{{ (!isset($useredit)) ? old('lastname') : $useredit->lastname }}" />
            <label for="name">{{ trans('moduleusers.lastname') }}</label>
            @if ($errors->has('lastname'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('lastname') }}</strong>
              </span>
            @endif
          </div>
          <div class="md-form">
            <input required name="email" type="email" class="form-control" value="{{ (!isset($useredit)) ? old('email') : $useredit->email }}" /><label for="email">{{ trans('cms.email') }}</label>
            @if ($errors->has('email'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>
          <div class="md-form">
            <input @if(!isset($useredit))
            required 
            @endif
            type="password" name="password" class="form-control" /><label for="password}">{{ trans('moduleusers.password') }}</label>
            @if ($errors->has('password'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
            @endif
          </div>
          <div class="md-form">
            <input @if(!isset($useredit))
            required 
            @endif
            type="password" name="password_confirmation" class="form-control" />
            <label for="confirmpassword">{{ trans('moduleusers.confirmpassword') }}</label>
            @if ($errors->has('password_confirmation'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <label for="roles_id">{{ trans('moduleroles.rol') }}</label>
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
              <a class="btn btn-danger waves-effect" href="{{ route('cogroupcms.users.home') }}">{{ trans('cms.txtbtncancel') }} <i class="fas fa-ban"></i></a>
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
@endsection
