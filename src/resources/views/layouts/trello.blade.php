@extends('index')
@section('title', $title)

@section('content')
    <section class="trello-board">
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
    </section>
@endsection

@section('head')
    <script>
        window.channel.bind('update-trello', function(data) {
            // parse the received data as JSON
            const body = JSON.parse(JSON.stringify(data));

            // clone the HTML element with an ID that matches `body.event` and save the cloned element in `oldEvent`
            let oldEvent = $(`#${body.event}`).clone();

            // remove the original HTML element with an ID matching `body.event` from the DOM
            $(`#${body.event}`).remove();

            // add the previously cloned element at the end of the HTML element with an ID matching `body.status`
            $(`#${body.status}`).append(oldEvent);
        });

        window.channel.bind('remove-trello', function(data) {
            const body = JSON.parse(JSON.stringify(data));
            $(`#${body.event}`).remove()
        });

        window.channel.bind('create-trello', function(data) {
            const body = JSON.parse(JSON.stringify(data));

            $(`#incoming`).append(`
                    <a id="${body.event}" href="https://akce.fluffici.eu/event?id=${body.event}">
                            <div class="trello-card">
                                <img src="${body.thumbnail}" alt="${body.event}" ${body.thumbnail  === "none" ? 'hidden' : '' }>
                                <div class="card-title">${body.name}</div>
                                <div class="card-description">${body.description}</div>
                                <div class="card-date-time">${body.time}</div>
                            </div>
                    </a>
            `)
        });
    </script>
@endsection
