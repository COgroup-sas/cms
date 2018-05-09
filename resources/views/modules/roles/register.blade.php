@extends('admin.layouts.main')

@section('content')
<body class="">

  <section class="content">
    <div class="container-fluid">
      <!-- Input -->
      <div class="row clearfix">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h2>
                @if(isset($roledit))
                {{ trans('modules.editrol') }}
                @else
                {{ trans('modules.addrol') }}
                @endif
              </h2>
            </div>
            <div class="card-body">
              <form role="form" id="form_advanced_validation" class="masked-input" method="POST" action="{{ route('rolpost') }}">
                {{ csrf_field() }}
                @if(isset($roledit))
                <input name="id" type="hidden" value="{{ $roledit->id }}" />
                @endif
                <label for="name">{{ trans('moduleroles.name') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <input required name="rolname" type="text" class="form-control" placeholder="{{ trans('moduleroles.name') }}" value="{{ (!isset($roledit)) ? old('rolname') : $roledit->rolname }}" />
                    @if ($errors->has('rolname'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('rolname') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <label for="phone">{{ trans('moduleroles.description') }}</label>
                <div class="form-group">
                  <div class="form-line">
                    <textarea name="description" class="form-control" placeholder="{{ trans('moduleroles.description') }}">{{ (!isset($roledit)) ? old('description') : $roledit->description }}</textarea>
                    @if ($errors->has('description'))
                      <span class="form-text text-danger">
                        <strong>{{ $errors->first('description') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-6 text-right">
                    <a class="btn btn-danger waves-effect" href="{{ route('roleshome') }}">{{ trans('cms.txtbtncancel') }} <i class="fas fa-ban"></i></a>
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
