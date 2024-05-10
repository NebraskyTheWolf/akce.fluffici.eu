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
                            <li class="list-group-item"><strong>Reporter:</strong> {{ $report->username }}</li>
                            <li class="list-group-item"><strong>Reason:</strong> {{ $report->reason }}</li>

                            @if($report->isLegalPurpose === 1)
                                <li class="list-group-item"><strong style="color: red">DMCA</strong></li>
                            @endif

                            @if($report->reviewed === 1)
                                <li class="list-group-item"><strong>Reviewed By:</strong> {{ $report->reviewed_by }}</li>
                                <li class="list-group-item"><strong>Action taken:</strong>
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
