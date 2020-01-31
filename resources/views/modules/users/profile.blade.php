@extends('cogroupcms::layouts.main')

@section('content')
  <div class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="title">{{ $title }}</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('cogroupcms.usersprofilesave') }}" method="POST" class="form needs-validation" novalidate  enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ trans('cms.email') }}</label>
                    <input type="text" class="form-control" disabled="" placeholder="Company" value="{{ $profile->email }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 pr-1">
                  <div class="form-group">
                    <label>{{ trans('moduleusers.name') }}</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $profile->name }}">
                  </div>
                  @if ($errors->has('name'))
                    <span class="form-text text-danger">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="col-md-6 pl-1">
                  <div class="form-group">
                    <label>{{ trans('moduleusers.lastname') }}</label>
                    <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="{{ $profile->lastname }}">
                  </div>
                  @if ($errors->has('lastname'))
                    <span class="form-text text-danger">
                      <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              @if($profile->social == 'N')
              <div class="row">
                <div class="col-md-6 pr-1">
                  <div class="form-group">
                    <label>{{ trans('moduleusers.password') }}</label>
                    <input type="password" autocomplete="" class="form-control" placeholder="{{ trans('moduleusers.password') }}">
                  </div>
                  @if ($errors->has('password_confirmation'))
                    <span class="form-text text-danger">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="col-md-6 pl-1">
                  <div class="form-group">
                    <label>{{ trans('moduleusers.confirmpassword') }}</label>
                    <input type="password" autocomplete="" class="form-control" placeholder="{{ trans('moduleusers.confirmpassword') }}">
                  </div>
                </div>
              </div>
              @endif
              @if(empty($profile->avatar))
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ trans('moduleusers.photo') }}</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control" id="customFile" accept="image/jpeg,image/gif,image/png,image/svg+xml" name="photo">
                      <label class="custom-file-label" for="customFile">{{ trans('cms.pleaseselectfile') }}</label>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              <!--<div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 pr-1">
                  <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" placeholder="City" value="Mike">
                  </div>
                </div>
                <div class="col-md-4 px-1">
                  <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" placeholder="Country" value="Andrew">
                  </div>
                </div>
                <div class="col-md-4 pl-1">
                  <div class="form-group">
                    <label>Postal Code</label>
                    <input type="number" class="form-control" placeholder="ZIP Code">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>About Me</label>
                    <textarea rows="4" cols="80" class="form-control" placeholder="Here can be your description" value="Mike">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                  </div>
                </div>
              </div>-->
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <button class="btn btn-primary btn-round" data-background-color="{{ config('cogroupcms.color_theme') }}" type="submit">{{ trans('cms.textbtnsubmit') }} <i class="fa fa-cloud"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-user">
          <div class="image">
            <img src="{{ asset('vendor/cogroup/cms/images/bg.jpg') }}" style="width: 100%; height: 100%">
          </div>
          <div class="card-body">
            <div class="author">
              <a href="#">
                <img class="avatar border-gray" src="{{ (is_null($profile->image_id) and is_null($profile->avatar)) ? 
                asset('vendor/cogroup/cms/images/default-avatar.png') : 
                ((!is_null($profile->image_id)) ?
                  route('getFile', [$profile->image_id]) :
                  $profile->avatar)
                }}" alt="{{ $profile->name }}">
                <h5 class="title">{{ $profile->name }}</h5>
              </a>
              <p class="description">
                {{ $profile->roles->rolname }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection