@extends('index')
@section('title', $title)

@section('content')
    <section class="trello-board">
        @if($incoming->isEmpty() && $started->isEmpty() && $finished->isEmpty() && $cancelled->isEmpty())
            <div class="header">
                <h3><i class="fas fa-spinner fa-spin"></i>{{ __('common.no_events') }}</h3>
            </div>
        @else
            <div class="trello-column">
                <h3>{{ __('common.incoming') }}</h3>
                <div class="trello-column-content">
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
            </div>

            <div class="trello-column">
                <h3>{{ __('common.started') }}</h3>
                <div class="trello-column-content">
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
            </div>

            <div class="trello-column">
                <h3>{{ __('common.finished') }}</h3>
                <div class="trello-column-content">
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
            </div>

            <div class="trello-column">
                <h3>{{ __('common.cancelled') }}</h3>
                <div class="trello-column-content">
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
            </div>
        @endif
    </section>
@endsection
