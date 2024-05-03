@extends('index')

@section('title', $title)

@section('content')
    <section class="trello-board justify-content-center">
        @if(empty($incoming) && empty($started) && empty($finished) && empty($cancelled))
            <h3>{{ __('common.no_events') }}</h3>
        @endif

        @if(!empty($incoming))
            <div class="trello-column">
                <h3>{{ __('common.incoming') }}</h3>
                @foreach($incoming as $event)
                    <a href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                        <div class="trello-card">
                            <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}">
                            <div class="card-title">{{ $event->name }}</div>
                            <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                            <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if(!empty($started))
           <div class="trello-column">
               <h3>{{ __('common.started') }}</h3>
               @foreach($started as $event)
                   <a href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                       <div class="trello-card">
                           <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}">
                           <div class="card-title">{{ $event->name }}</div>
                           <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                           <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                       </div>
                   </a>
               @endforeach
           </div>
        @endif

        @if(!empty($finished))
            <div class="trello-column">
                <h3>{{ __('common.finished') }}</h3>
                @foreach($finished as $event)
                    <a href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                        <div class="trello-card">
                            <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}">
                            <div class="card-title">{{ $event->name }}</div>
                            <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                            <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                        </div>
                    </a>
                @endforeach
           </div>
        @endif

        @if(!empty($cancelled))
           <div class="trello-column">
               <h3>{{ __('common.cancelled') }}</h3>

               @foreach($cancelled as $event)
                   <a href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                       <div class="trello-card">
                           <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}">
                           <div class="card-title">{{ $event->name }}</div>
                           <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                           <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                       </div>
                   </a>
               @endforeach
           </div>
        @endif
    </section>
@endsection
