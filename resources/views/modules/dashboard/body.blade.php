@extends('cogroupcms::layouts.main')

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-chart">
        <div class="card-header">
          <h4>{{ trans('cms.welcome').$user->name }}</h4>
        </div>
        <div class="card-body">
          <h5 class="font-weight-bold">Últimas notificaciones</h5>

          <ul class="collapsible popout collapsible-materialize">
            @foreach($notifications as $notification)
            <li>
              <div class="collapsible-header">{{ $notification->data['subject'] }}</div>
              <div class="collapsible-body">{!! $notification->data['message'] !!}</div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection