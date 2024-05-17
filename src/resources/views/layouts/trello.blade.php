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
                <div id="incoming" class="trello-column-content">
                    @foreach($incoming as $event)
                        <a id="{{ $event->event_id }}" href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                            <div class="trello-card">
                                <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}" {{ $event->thumbnail === "none" ? 'hidden' : ''}}>
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
                <div id="started" class="trello-column-content">
                    @foreach($started as $event)
                        <a id="{{ $event->event_id }}" href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                            <div class="trello-card">
                                <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}" {{ $event->thumbnail === "none" ? 'hidden' : ''}}>
                                <div class="card-title">{{ $event->name }}</div>
                                <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                                <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div id="ended" class="trello-column">
                <h3>{{ __('common.finished') }}</h3>
                <div class="trello-column-content">
                    @foreach($finished as $event)
                        <a id="{{ $event->event_id }}" href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                            <div class="trello-card">
                                <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}" {{ $event->thumbnail === "none" ? 'hidden' : ''}}>
                                <div class="card-title">{{ $event->name }}</div>
                                <div class="card-description">{{ strip_tags($event->descriptions) }}</div>
                                <div class="card-date-time">{{ __('common.date') }}: {{ $event->startAt }} - {{ __('common.time') }}: {{ $event->startAtTime }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div id="cancelled" class="trello-column">
                <h3>{{ __('common.cancelled') }}</h3>
                <div class="trello-column-content">
                    @foreach($cancelled as $event)
                        <a id="{{ $event->event_id }}" href="{{ env('PUBLIC_URL') }}/event?id={{ $event->event_id }}">
                            <div class="trello-card">
                                <img src="{{ $event->thumbnail }}" alt="{{ $event->event_id }}" {{ $event->thumbnail === "none" ? 'hidden' : ''}}>
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

@section('head')
    <script>
        // subscribers to a Pusher channel called 'notifications-event'
        const channel = window.pusher.subscribe('notifications-event');

        // bind a function that will be triggered everytime an 'update-trello' event is received on this channel
        channel.bind('update-trello', function(data) {

            // parse the received data as JSON
            const body = JSON.parse(JSON.stringify(data));

            // clone the HTML element with an ID that matches `body.event` and save the cloned element in `oldEvent`
            let oldEvent = $(`#${body.event}`).clone();

            // remove the original HTML element with an ID matching `body.event` from the DOM
            $(`#${body.event}`).remove();

            // add the previously cloned element at the end of the HTML element with an ID matching `body.status`
            $(`#${body.status}`).append(oldEvent);
        });
    </script>
@endsection
