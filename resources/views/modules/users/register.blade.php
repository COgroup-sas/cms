@extends('admin.layouts.main')

@section('content')
<section class="content">
    <div class="container-fluid">
      <!-- Input -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h2>
                @if(isset($useredit))
                {{ trans('modules.edituser') }}
                @else
                {{ trans('modules.adduser') }}
                @endif
                <small>{{ trans('moduleusers.basicinformation') }}</small>
              </h2>
            </div>
            <div class="card-body">
              <form role="form" id="form_advanced_validation" class="masked-input" method="POST" action="{{ route('userspost') }}">
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
                <label for="clients_id">Cliente</label>
                <div class="form-group">
                  <div class="form-line">
                    <select name="clients_id" class="form-control show-tick">
                    @foreach($clients as $client)
                      <option 
                      @if(old('clients_id') == $client->id || (isset($useredit) and $useredit->clients_id == $client->id ) )
                        selected="selected" 
                      @endif
                      value="{{ $client->id }}">{{ $client->name }}{{ (!empty($client->lastname)) ? " ".$client->lastname : '' }}</option>
                    @endforeach
                    </select>
                    @if ($errors->has('clients_id'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('clients_id') }}</strong>
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
                <label for="roles_id">{{ trans('moduleusers.rol') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    @foreach($roles as $rol)
                      <input required type="radio" name="roles_id" id="{{ mb_strtolower($rol->rolname) }}" value="{{ $rol->id }}" class=""
                      @if(old('roles_id') == $rol->id || (isset($useredit) and $useredit->roles_id == $rol->id))
                        checked="checked" 
                      @endif
                      >
                      <label for="{{ mb_strtolower($rol->rolname) }}">{{ $rol->rolname }}</label>
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
                    <a class="btn btn-danger waves-effect" href="{{ route('usershome') }}">{{ trans('cms.txtbtncancel') }} <i class="fas fa-ban"></i></a>
                  </div>
                  <div class="col-6 text-left">
                    <button class="btn btn-success waves-effect" type="submit">{{ trans('cms.textbtnsubmit') }}</button>
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
