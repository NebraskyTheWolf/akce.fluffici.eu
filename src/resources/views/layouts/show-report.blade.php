@extends('index')
@section('title', __('common.report'))

@section('content')
    <div class="container-event">
        <h1>{{ __('common.report') }}</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        @if($report->reviewed === 1)
                            <h5 class="card-title">{{ __('common.report.reviewed') }}</h5>
                            <p class="card-text">{{ $report->messages }}</p>
                        @else
                            <h5 class="card-title">{{ __('common.report.pending_review') }}</h5>
                        @endif
                        <p class="card-text">{{ $report->messages }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>{{ __('common.reporter') }}:</strong> {{ $report->username }}</li>
                            <li class="list-group-item"><strong>{{ __('common.reason') }}:</strong> {{ $report->reason }}</li>

                            @if($report->reviewed === 1)
                                <li class="list-group-item"><strong>{{ __('common.reviewed.by') }}:</strong> {{ $report->reviewed_by }}</li>
                                <li class="list-group-item"><strong>{{ __('common.action.taken') }}:</strong>
                                    {{ $report->type }}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
