@extends('cogroupcms::layouts.main')

@section('content')
<div class="row clearfix">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h2>
          @if(isset($roledit))
          {{ trans('moduleroles.edit') }}
          @else
          {{ trans('moduleroles.add') }}
          @endif
        </h2>
      </div>
      <div class="card-body">
        <form role="form" class="masked-input needs-validation" method="POST" action="{{ route('cogroupcms.roles.save') }}" novalidate>
          {{ csrf_field() }}
          @if(isset($roledit))
          <input name="id" type="hidden" value="{{ $roledit->id }}" />
          @endif
          <div class="md-form">
            <input required="true" name="rolname" type="text" class="form-control" value="{{ (!isset($roledit)) ? old('rolname') : $roledit->rolname }}" />
            <label for="name">{{ trans('moduleroles.name') }}</label>
            @if ($errors->has('rolname'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('rolname') }}</strong>
              </span>
            @endif
          </div>
          <div class="md-form mt-5">
            <textarea name="description" class="form-control md-textarea">{{ (!isset($roledit)) ? old('description') : $roledit->description }}</textarea>
            <label for="phone">{{ trans('moduleroles.description') }}</label>
            @if ($errors->has('description'))
              <span class="form-text text-danger">
                <strong>{{ $errors->first('description') }}</strong>
              </span>
            @endif
          </div>
          <div class="row">
            <div class="col-6 text-right">
              <a class="btn btn-danger waves-effect" href="{{ route('cogroupcms.roles.home') }}">{{ trans('cms.txtbtncancel') }} <i class="fas fa-ban"></i></a>
            </div>
            <div class="col-6 text-left">
              <button class="btn btn-success waves-effect" type="submit">{{ trans('cms.textbtnsubmit') }} <i class="fas fa-cloud"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
