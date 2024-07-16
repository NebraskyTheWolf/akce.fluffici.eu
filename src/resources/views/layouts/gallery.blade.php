@extends('index')
@section('title', $title)

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="container-event">
        <div class="min-h-screen flex flex-col items-center">
            <div class="container mx-auto px-4" x-data="galleryComponent">
                <div class="flex justify-center py-4">
                    <input
                        type="text"
                        placeholder="Search.."
                        class="px-4 py-2 w-full max-w-md rounded text-black"
                        x-model="query"
                        @input.debounce.500ms="search()">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <template x-for="event in filteredEvents" :key="event.event_id">
                        <div class="bg-gray-800 p-4 rounded flex flex-col items-center">
                            <div class="bg-gray-700 w-full h-48 flex items-center justify-center mb-4">
                                <img :src="'https://autumn.fluffici.eu/photos/' + event.picture.attachment_id" alt="Thumbnail" class="w-full h-full object-cover" src="">
                            </div>
                            <div class="text-lg mb-2" x-text="event.name"></div>
                            <a class="bg-blue-500 text-white px-4 py-2 rounded" :href="'/gallery/album/' + event.event_id">Více</a>
                        </div>
                    </template>
                </div>
                <div class="flex justify-between w-full py-4" x-show="events.length > 0">
                    <button
                        class="bg-gray-500 text-white px-4 py-2 rounded"
                        @click="prevPage()"
                        :hidden="page <= 1">
                        <i class="fas fa-arrow-left"></i> Předchozí
                    </button>
                    <button
                        class="bg-gray-500 text-white px-4 py-2 rounded"
                        @click="nextPage()"
                        :hidden="page >= totalPages">
                        Další <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("script")
    <script>
        function galleryComponent() {
            return {
                events: @json($events->items()),
                query: '',
                page: {{ $events->currentPage() }},
                totalPages: {{ $events->lastPage() }},
                filteredEvents: [],

                init() {
                    this.events = this.removeDuplicates(this.events);
                    this.filteredEvents = this.events;
                },

                search() {
                    if (this.query === '') {
                        this.filteredEvents = this.events;
                    } else {
                        this.filteredEvents = this.events.filter(event =>
                            event.name.toLowerCase().includes(this.query.toLowerCase())
                        );
                    }
                },

                prevPage() {
                    if (this.page > 1) {
                        this.page--;
                        this.fetchEvents();
                    }
                },

                nextPage() {
                    if (this.page < this.totalPages) {
                        this.page++;
                        this.fetchEvents();
                    }
                },

                async fetchEvents() {
                    const response = await fetch(`{{ route('gallery') }}?page=${this.page}&query=${this.query}`);
                    const data = await response.json();
                    this.events = this.removeDuplicates(data.events);
                    this.totalPages = data.total_pages;
                    this.filteredEvents = this.events;
                },

                removeDuplicates(events) {
                    const seen = new Set();
                    return events.filter(event => {
                        if (seen.has(event.event_id)) {
                            return false;
                        }
                        seen.add(event.event_id);
                        return true;
                    });
                }
            }
        }
    </script>
@endsection
