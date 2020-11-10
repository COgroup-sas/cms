@extends('cogroupcms::layouts.main')

@section('content')
<div class="row clearfix">
  <div class="col-12">
    <h4>
      {{ mb_strtoupper(trans('notifications.title')) }}
      <small>{{ mb_strtoupper(trans('cms.list')) }}</small>
    </h4>
    <ul class="nav nav-tabs nav-justified" id="myTabJust" role="tablist" data-background-color="dark">
      <li class="nav-item">
        <a class="nav-link active" id="unread-tab" data-toggle="tab" href="#unread" role="tab" aria-controls="unread"
          aria-selected="true">
            <i class="far fa-envelope"></i>
            {{ trans('notifications.unread') }}
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="read-tab" data-toggle="tab" href="#read" role="tab" aria-controls="read"
          aria-selected="false">
            <i class="far fa-envelope-open"></i>
            {{ trans('notifications.read') }}
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
          aria-selected="false">
            <i class="fas fa-mail-bulk"></i>
            {{ trans('notifications.all') }}
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('cogroupcms.notifications.readall') }}">
          <i class="fas fa-check-double"></i>
          {{ trans('notifications.markread') }}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link fs-0-9" href="{{ route('cogroupcms.notifications.delete') }}">
          <i class="fas fa-trash-alt"></i>
          {{ trans('notifications.delete') }}
        </a>
      </li>
    </ul>
    <div class="tab-content card p-3" id="myTabContentJust">
      <div class="tab-pane fade show active" id="unread" role="tabpanel" aria-labelledby="home-tab-just">
        <ul class="list-group">
          @foreach ($notifications as $notification)
            @if(is_null($notification->read_at) and !is_null($notification->data))
              <li class="list-group-item">
                <a href="{{ route('cogroupcms.notifications.notification', $notification->id) }}">
                  <div class="row">
                    <div class="col-1 text-color" data-color="{{ config('cogroupcms.color_theme') }}">
                      @php
                      $from = Cogroup\Cms\Models\User::find($notification->data['from_id']);
                      @endphp
                      <img class="rounded-circle img-fluid" src="{{ (is_null($from->image_id) and is_null($from->avatar)) ? 
                    asset('vendor/cogroup/cms/images/default-avatar.png') : 
                    ((!is_null($from->image_id)) ?
                      route('files.getFile', [$from->image_id]) :
                      $from->avatar)
                    }}" alt="{{ $from->full_name }}">
                      {{ $from->full_name }}
                    </div>
                    <div class="col-11">
                      <h6 class="text-color" data-color="{{ config('cogroupcms.color_theme') }}">{{ $notification->data['subject'] }}</h6>
                      <p class="text-color" data-color="light">{!! $notification->data['message'] !!}</p>
                      <small class="text-color" data-color="light"><strong>{{ $notification->created_at->format('Y-m-d h:i a') }}</strong></small>
                    </div>
                  </div>
                </a>
              </li>
            @endif
          @endforeach
        </ul>
      </div>
      <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
        <ul class="list-group">
          @foreach ($notifications as $notification)
            @if(!is_null($notification->read_at) and !is_null($notification->data))
              <li class="list-group-item">
                <a href="{{ route('cogroupcms.notifications.notification', $notification->id) }}">
                  <div class="row">
                    <div class="col-1 text-color" data-color="{{ config('cogroupcms.color_theme') }}">
                      @php
                      $from = Cogroup\Cms\Models\User::find($notification->data['from_id']);
                      @endphp
                      <img class="rounded-circle img-fluid" src="{{ (is_null($from->image_id) and is_null($from->avatar)) ? 
                    asset('vendor/cogroup/cms/images/default-avatar.png') : 
                    ((!is_null($from->image_id)) ?
                      route('files.getFile', [$from->image_id]) :
                      $from->avatar)
                    }}" alt="{{ $from->full_name }}">
                      {{ $from->full_name }}
                    </div>
                    <div class="col-11">
                      <h6 class="text-color" data-color="{{ config('cogroupcms.color_theme') }}">{{ $notification->data['subject'] }}</h6>
                      <p class="text-color" data-color="light">{!! $notification->data['message'] !!}</p>
                      <small class="text-color" data-color="light"><strong>{{ $notification->created_at->format('Y-m-d h:i a') }}</strong></small>
                    </div>
                  </div>
                </a>
              </li>
            @endif
          @endforeach
        </ul>
      </div>
      <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
        <ul class="list-group">
          @foreach ($notifications as $notification)
            @if(!is_null($notification->data))
            <li class="list-group-item">
              <a href="{{ route('cogroupcms.notifications.notification', $notification->id) }}">
                <div class="row">
                  <div class="col-1 text-color" data-color="{{ config('cogroupcms.color_theme') }}">
                    @php
                    $from = Cogroup\Cms\Models\User::find($notification->data['from_id']);
                    @endphp
                    <img class="rounded-circle img-fluid" src="{{ (is_null($from->image_id) and is_null($from->avatar)) ? 
                  asset('vendor/cogroup/cms/images/default-avatar.png') : 
                  ((!is_null($from->image_id)) ?
                    route('files.getFile', [$from->image_id]) :
                    $from->avatar)
                  }}" alt="{{ $from->full_name }}">
                    {{ $from->full_name }}
                  </div>
                  <div class="col-11">
                    <h6 class="text-color" data-color="{{ config('cogroupcms.color_theme') }}">{{ $notification->data['subject'] }}</h6>
                    <p class="text-color" data-color="light">{!! $notification->data['message'] !!}</p>
                    <small class="text-color" data-color="light"><strong>{{ $notification->created_at->format('Y-m-d h:i a') }}</strong></small>
                  </div>
                </div>
              </a>
            </li>
            @endif
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection