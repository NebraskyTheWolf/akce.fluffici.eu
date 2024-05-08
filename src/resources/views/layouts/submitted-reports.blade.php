@extends('index')
@section('title', __('common.submitted.reports'))

@section('content')
    <div class="container-event">
        <h1>{{ __('common.submitted.reports') }}</h1>

        @if($reports->isEmpty())
            <p>{{ __('common.no.reports') }}</p>
        @else
            <ul class="reports-list">
                @foreach($reports as $report)
                    <li class="report">
                        <div class="report-info">
                            <h2>{{ $report->reason }}</h2>
                            <p>{{ $report->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                        <div class="report-actions">
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-primary">{{ __('common.view.report') }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
