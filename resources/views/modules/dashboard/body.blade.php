@extends('cogroupcms::layouts.main')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-chart">
        <div class="card-header">
          <h5 class="card-category">{{ trans('cms.welcome').$user->name }}</h5>
        </div>
        <div class="card-body">
        </div>
      </div>
    </div>
  </div>
@endsection