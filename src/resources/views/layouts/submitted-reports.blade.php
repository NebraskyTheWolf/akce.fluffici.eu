@extends('index')
@section('title', __('common.submitted.reports'))

@section('content')
    <div class="container-event">
        @if($reports->isEmpty())
            <p>{{ __('common.no.reports') }}</p>
        @else
            <ul class="reports-list">
                @foreach($reports as $report)
                    <li class="report">
                        <div class="report-info">
                            <h2>{{ $report->reason }} {{ $report->reviewed ? __('common.review.done') : __('common.review.pending')}}</h2>
                            <p>{{ $report->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                        <div class="report-actions">
                            <a href="{{ route('reports.show', $report->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M11 14h1v4h1"></path>
                                    <path d="M12 11h.01"></path>
                                </svg>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
