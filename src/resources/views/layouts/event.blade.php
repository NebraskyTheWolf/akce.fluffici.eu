@php use App\Models\ReportedAttachments; @endphp
@extends('index')
@section('title', $event->name)
@section('image', $event->banner_url)
@section('description', strip_tags($event->descriptions) . ' · ' . ucwords(strtolower($event->status)))

@section('content')
    <section class="container-event">
        <img src="{{ $event->banner_url }}" alt="Event Banner" class="event-banner">

        <section class="event-info-card">
            <div class="event-info-header">
                <h2 class="event-info-title">{{ $event->name }}</h2>
                <div class="event-info-status">{{ $event->status }}</div>
            </div>
            <div class="event-info-details">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                    <path d="M16 3l0 4" />
                    <path d="M8 3l0 4" />
                    <path d="M4 11l16 0" />
                    <path d="M8 15h2v2h-2z" />
                </svg>
                {{ __('common.start.date') }}: {{ $event->startAt }}
            </div>

            <div class="event-info-details">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-check" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M15 19l2 2l4 -4" />
                </svg>
                {{ __('common.end.date') }}: {{ $event->endAt }}
            </div>

            <div class="event-info-details" {{ $event->link === null ? 'hidden' : '' }}>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" />
                </svg>
                {{ __('common.link') }}: <a href="{{ $event->link }}" class="event-info-link">{{ $event->link }}</a>
            </div>

            <div class="event-info-details">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                </svg>
                {{ __('common.description') }}: {!! $event->descriptions !!}
            </div>
        </section>

        @if($event->type === "PHYSICAL" && $event->map_url != null)
            <section class="pictures">
                <h3 class="pictures-header">Mapa</h3>
                <div class="pictures-gallery">
                    <iframe id="map"
                        src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&hl=cs;z=4&amp;output=embed"
                        width="800"
                        height="400"
                        frameborder="0"
                        style="border:0" allowfullscreen>
                    </iframe>
                </div>
            </section>

            <section class="pictures">
                <h3 class="pictures-header">{{ __('common.location') }}</h3>
                <div class="pictures-gallery">
                    <img class="skeleton-animation" src="{{ $event->map_url }}" alt="location"
                         onclick="openModal('{{ $event->map_url }}', 'map', 'none', 'Administrator', '')">
                </div>
            </section>
        @endif

        @if ($event->type === "ONLINE")
            <iframe src="https://discord.com/widget?id=606534136806637589&theme=dark" width="350" height="500"
                    allowtransparency="true" frameborder="0"
                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        @else
            <section class="pictures">
                <h3 class="pictures-header">{{ __('common.pictures') }}</h3>
                <div class="pictures-gallery">
                    @foreach($pictures as $picture)
                        <div class="pictures-img skeleton-animation">
                            @if(ReportedAttachments::where('attachment_id', $picture->attachment_id)->exists())
                                <div class="spoiler">
                                    <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}" onclick="openModal('https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}', '{{ $picture->attachment_id }}', '{{ $picture->user->avatar }}', '{{ $picture->user->name }}', '{{ $picture->user->discord_id }}')"
                                        class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}">
                                    <div class="alert-overlay">
                                        <div class="alert-message">
                                            <p style="color: #fff; text-transform: uppercase; font-family: 'Lexend Deca', serif;">
                                                Pozor, tato fotka byla nahlášena
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}" onclick="openModal('https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}', '{{ $picture->attachment_id }}', '{{ $picture->user->avatar }}', '{{ $picture->user->name }}', '{{ $picture->user->discord_id }}')"
                                     class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}">
                            @endif
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
                    <p id="attachment-id" hidden=""></p>
                </div>
            </div>
            <div class="dropdown">
                <div class="dropdown-content">
                    <a id="report-id" href="#" class="btn">Report</a>
                </div>
            </div>
        </div>
        <div id="custom-menu">
            <div class="menu-item" id="menu-item-1">Report</div>
            <div class="menu-item" id="menu-item-2">Copy ID</div>
            <div class="menu-item" id="menu-item-3">Copy Attachment URL</div>
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
                document.getElementById("attachment-id").innerText = attachmentId;
            }
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function showContextMenu(x, y) {
            const menu = document.getElementById("custom-menu");
            menu.style.display = "block";
            menu.style.left = x + "px";
            menu.style.top = y + "px";
        }

        function hideContextMenu() {
            const menu = document.getElementById("custom-menu");
            menu.style.display = "none";
        }

        document.addEventListener("contextmenu", function (event) {
            event.preventDefault();
            showContextMenu(event.pageX, event.pageY);
        });

        document.addEventListener("click", function (event) {
            hideContextMenu();
        });

        document.getElementById('menu-item-1').addEventListener('click', function () {
            const attachmentId = document.getElementById("attachment-id").innerText
            window.location.href = `https://akce.fluffici.eu/report-content?attachment=${attachmentId}`
        });

        document.getElementById('menu-item-2').addEventListener('click', function () {
            const copyText = document.getElementById("attachment-id").innerText;
            navigator.clipboard.writeText(copyText).then(function () {
                toastr.info('{{ __('common.clipboard.copied') }}')
            }, function (err) {
                toastr.error('{{ __('common.clipboard.error') }}')
            });
        });

        document.getElementById('menu-item-3').addEventListener('click', function () {
            const copyText = document.getElementById("attachment-id").innerText;
            navigator.clipboard.writeText(`https://autumn.fluffici.eu/photos/${copyText}`).then(function () {
                toastr.info('{{ __('common.clipboard.copied') }}')
            }, function (err) {
                toastr.error('{{ __('common.clipboard.error') }}')
            });
        });
    </script>
@endsection
