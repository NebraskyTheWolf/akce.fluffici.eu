@php use App\Models\ReportedAttachments; @endphp
@extends('index')
@section('title', $title)

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="container-event" x-data="modalHandler()">
        <div class="min-h-screen flex flex-col items-center">
            <div class="container mx-auto px-4">

                <section class="pictures">
                    <h3 class="pictures-header">{{ __('common.pictures') }}</h3>
                    <div class="pictures-gallery">
                        @foreach($pictures as $picture)
                            <div class="pictures-img">
                                @if(ReportedAttachments::where('attachment_id', $picture->attachment_id)->exists())
                                    <div class="spoiler">
                                        <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}"
                                             data-image-url="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}"
                                             data-author-avatar="{{ $picture->user->avatar }}"
                                             data-author-name="{{ $picture->user->name }}"
                                             @click="openModal($event)"
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
                                    <img src="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}" alt="{{ $picture->attachment_id }}"
                                         data-image-url="https://autumn.fluffici.eu/photos/{{ $picture->attachment_id }}"
                                         data-author-avatar="{{ $picture->user->avatar }}"
                                         data-author-name="{{ $picture->user->name }}"
                                         @click="openModal($event)"
                                         class="pictures-img" data-picture-attachment="{{ $picture->attachment_id }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="flex justify-between w-full py-4">
                    @if ($event->pictures->onFirstPage())
                        <span class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed"><i class="fas fa-arrow-left"></i> Předchozí</span>
                    @else
                        <a href="{{ $event->pictures->previousPageUrl() }}" class="bg-gray-500 text-white px-4 py-2 rounded"><i class="fas fa-arrow-left"></i> Předchozí</a>
                    @endif
                    @if ($event->pictures->hasMorePages())
                        <a href="{{ $event->pictures->nextPageUrl() }}" class="bg-gray-500 text-white px-4 py-2 rounded">Další <i class="fas fa-arrow-right"></i></a>
                    @else
                        <span class="bg-gray-500 text-white px-4 py-2 rounded cursor-not-allowed">Další <i class="fas fa-arrow-right"></i></span>
                    @endif
                </div>
            </div>
        </div>

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

@section("script")
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
        });
    </script>
@endsection
