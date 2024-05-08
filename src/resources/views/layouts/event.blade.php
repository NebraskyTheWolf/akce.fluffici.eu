@extends('index')
@section('title', $event->name)

@section('content')
    <section class="container-event">
        <img src="{{ $event->banner_url }}" alt="Event Banner" class="event-banner">

        <section class="event-info-card">
            <div class="event-info-header">
                <h2 class="event-info-title">{{ $event->name }}</h2>
                <div class="event-info-status">{{ $event->status }}</div>
            </div>
            <p class="event-info-details">{{ __('common.start.date') }}: {{ $event->startAt }}</p>
            <p class="event-info-details">{{ __('common.end.date') }}: {{ $event->endAt }}</p>
            <p class="event-info-details">{{ __('common.link') }}: <a href="{{ $event->link }}" class="event-info-link">{{ $event->link }}</a></p>
            <p class="event-info-details">{{ __('common.description') }}: {{ strip_tags($event->descriptions) }}</p>
        </section>

        @if($event->type === "PHYSICAL" && $event->map_url != null)
            <section class="pictures">
                <h3 class="pictures-header">{{ __('common.location') }}</h3>
                <div class="pictures-gallery">
                    <img class="skeleton-animation" src="{{ $event->map_url }}" alt="location" onclick="openModal('{{ $event->map_url }}', 'map')">
                </div>
            </section>
        @endif

        @if ($event->type === "ONLINE")
            <iframe src="https://discord.com/widget?id=606534136806637589&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        @else
            <section class="pictures">
                <h3 class="pictures-header">{{ __('common.pictures') }}</h3>
                <div class="pictures-gallery">
                    @foreach($pictures as $picture)
                        <div class="pictures-img skeleton-animation">
                            <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}" onclick="openModal('https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}', '{{ $picture->attachment_id }}')"
                                 class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}">
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection

@section('modals')
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <img id="modalImg" src="" alt="Full Image">
            <div class="dropdown">
                <div class="dropdown-content">
                    <a id="report-id" href="#" class="btn">Report</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function openModal(imageUrl, attachmentId) {
            document.getElementById("modalImg").src = imageUrl;
            document.getElementById("myModal").style.display = "block";
            document.getElementById("report-id").href = `https://akce.fluffici.eu/report-content?attachment=${attachmentId}`
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
@endsection
