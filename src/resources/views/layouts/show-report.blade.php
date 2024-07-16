@extends('index')
@section('title', __('common.report'))

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="min-h-screen bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8">{{ __('common.report') }}</h1>
            <div class="flex justify-center">
                <div class="max-w-md w-full">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        @if($report->reviewed === 1)
                            <h5 class="text-xl font-semibold mb-4">{{ __('common.report.reviewed') }}</h5>
                            <p class="mb-4">{{ $report->messages }}</p>
                        @else
                            <h5 class="text-xl font-semibold mb-4">{{ __('common.report.pending_review') }}</h5>
                        @endif
                        <p class="mb-4">{{ $report->messages }}</p>
                        <ul class="divide-y divide-gray-700">
                            <li class="py-2"><strong>{{ __('common.reporter') }}:</strong> {{ $report->username }}</li>
                            <li class="py-2"><strong>{{ __('common.reason') }}:</strong> {{ $report->reason }}</li>

                            @if($report->reviewed === 1)
                                <li class="py-2"><strong>{{ __('common.reviewed.by') }}:</strong> {{ $report->reviewed_by }}</li>
                                <li class="py-2"><strong>{{ __('common.action.taken') }}:</strong> {{ $report->type }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
