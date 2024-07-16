@php use App\Models\ReportedAttachments; @endphp
@extends('index')
@section('title', $event->name)
@section('image', $event->banner_url)
@section('description', strip_tags($event->descriptions) . ' · ' . ucwords(strtolower($event->status)))

@section("head")
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="container-event" x-data="modalHandler()">
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
                <div class="blog-editor">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    </svg>
                    <p>{{ __('common.description') }}:</p>
                    <div class="description-content" contenteditable="false">
                        {!! $event->descriptions !!}
                    </div>
                </div>
            </div>
        </section>

        @if($event->type === "PHYSICAL")
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
        @endif

        @if($event->type === "PHYSICAL" && $event->map_url != null)
            <section class="pictures">
                <h3 class="pictures-header">{{ __('common.location') }}</h3>
                <div class="pictures-gallery">
                    <img src="{{ $event->map_url }}" alt="location"
                         data-image-url="{{ $event->map_url }}"
                         data-author-avatar="https://autumn.fluffici.eu/avatars/abwHrJNTWFU55eFKFt3bvFbzsiqHH9ru51eODeC-4C"
                         data-author-name="Asherro"
                         data-picture-attachment="none"
                         @click="openModal($event)"
                         class="mapa">
                </div>
            </section>
        @endif

        @if ($event->type === "ONLINE")
            <iframe src="https://discord.com/widget?id=606534136806637589&theme=dark" width="350" height="500"
                    allowtransparency="true" frameborder="0"
                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        @else
            <section class="pictures" {{ $event->status !== "ENDED" ? 'hidden' : '' }}>
                <h3 class="pictures-header">{{ __('common.pictures') }}</h3>
                <div class="pictures-gallery" x-data="contextMenuHandler()" @click.outside="hideContextMenu()">
                    @foreach($pictures as $picture)
                        <div class="pictures-img">
                            @if(ReportedAttachments::where('attachment_id', $picture->attachment_id)->exists())
                                <div class="spoiler">
                                    <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}"
                                         data-image-url="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}"
                                         data-author-avatar="{{ $picture->user->avatar }}"
                                         data-author-name="{{ $picture->user->name }}"
                                         @click="openModal($event)"
                                         class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}"
                                         @contextmenu.prevent="showContextMenu($event, '{{ $picture->attachment_id }}')">
                                    <div class="alert-overlay">
                                        <div class="alert-message">
                                            <p style="color: #fff; text-transform: uppercase; font-family: 'Lexend Deca', serif;">
                                                Pozor, tato fotka byla nahlášena
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}"
                                     data-image-url="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}"
                                     data-author-avatar="{{ $picture->user->avatar }}"
                                     data-author-name="{{ $picture->user->name }}"
                                     @click="openModal($event)"
                                     class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}"
                                     @contextmenu.prevent="showContextMenu($event, '{{ $picture->attachment_id }}')">
                            @endif
                        </div>
                    @endforeach

                    <div x-show="showMenu" :style="{ top: y + 'px', left: x + 'px' }" class="fixed bg-white shadow-md rounded-md overflow-hidden">
                        <a :href="`https://akce.fluffici.eu/report-content?attachment=${attachmentId}`" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Report</a>
                        <button @click="copyToClipboard(attachmentId)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Copy ID</button>
                        <button @click="copyToClipboard(`https://autumn.fluffici.eu/photos/${attachmentId}`)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Copy Attachment URL</button>
                    </div>

                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm py-1 px-2 rounded mt-1 w-auto" href="/gallery/album/{{ $event->event_id }}">Více</a>
                </div>
            </section>
        @endif

        <div x-show="open" x-on:click.away="closeModal()" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-90" style="display: none;">
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all w-full max-w-lg mx-auto">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg leading-6 font-medium text-white"></h3>
                        <button @click="closeModal" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">Close</span>
                            &times;
                        </button>
                    </div>
                    <div class="relative mt-3 group">
                        <img :src="imageUrl" alt="Full Image" class="max-w-full h-auto mx-auto">
                        <a :href="`https://akce.fluffici.eu/report-content?attachment=${attachmentId}`"
                           class="absolute top-0 left-0 m-2 text-white hidden group-hover:block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-10a9.99 9.99 0 00-9-5 9.99 9.99 0 00-9 5m18 5a9.99 9.99 0 01-9 5 9.99 9.99 0 01-9-5m18 0V6m0 5v5m-18 0V6m0 5v5m3 5h12"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="mt-5" x-show="authorAvatar !== 'none'">
                        <div class="flex items-center">
                            <img :src="authorAvatar" alt="Author Avatar" class="w-10 h-10 rounded-full">
                            <div class="ml-4">
                                <p class="text-sm font-medium text-white" x-text="authorName"></p>
                                <span class="text-xs text-gray-400">Autor</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalHandler', () => ({
                open: false,
                imageUrl: '',
                authorAvatar: '',
                authorName: '',
                attachmentId: '',
                openModal(event) {
                    this.imageUrl = event.target.dataset.imageUrl;
                    this.attachmentId = event.target.dataset.pictureAttachment;
                    this.authorAvatar = event.target.dataset.authorAvatar;
                    this.authorName = event.target.dataset.authorName;
                    this.open = true;
                },
                closeModal() {
                    this.open = false;
                }
            }));

            Alpine.data('contextMenuHandler', () => ({
                showMenu: false,
                x: 0,
                y: 0,
                attachmentId: '',
                showContextMenu(event, attachmentId) {
                    this.showMenu = true;
                    this.x = event.clientX;
                    this.y = event.clientY;
                    this.attachmentId = attachmentId;
                },
                hideContextMenu() {
                    this.showMenu = false;
                },
                copyToClipboard(text) {
                    window.navigator.clipboard.writeText(text)
                    this.showMenu = false;
                }
            }));
        });
    </script>
@endsection
