@extends('index')
@section('title', $event->name)

@section('head')
    <style>
        .author-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .author-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .author-details p {
            margin: 0;
            font-size: 16px;
            color: #fff;
        }

        .dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
@endsection

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
                    <img class="skeleton-animation" src="{{ $event->map_url }}" alt="location" onclick="openModal('{{ $event->map_url }}', 'map', 'none', '', '')">
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
                            <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}" onclick="openModal('https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}', '{{ $picture->attachment_id }}', '{{ $picture->user->avatar }}', '{{ $picture->user->name }}', '{{ $picture->user->discord_id }}')"
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
            <div class="author-info" id="info">
                <div class="author-avatar">
                    <img id="author-avatar" src="" alt="Author Avatar">
                </div>
                <div class="author-details">
                    <p id="author-name"></p>
                    <p id="author-id"></p>
                </div>
            </div>
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
        function openModal(imageUrl, attachmentId, authorAvatar, authorName, authorId) {
            document.getElementById("modalImg").src = imageUrl;
            document.getElementById("myModal").style.display = "block";
            document.getElementById("report-id").href = `https://akce.fluffici.eu/report-content?attachment=${attachmentId}`

            if (authorAvatar === "none") {
                $('#info').hide()
            } else {
                document.getElementById("author-avatar").src = authorAvatar;
                document.getElementById("author-name").innerText = authorName;
                document.getElementById("author-id").innerText = authorId;
            }
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
@endsection
