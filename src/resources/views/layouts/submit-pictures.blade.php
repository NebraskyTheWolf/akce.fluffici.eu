@extends('index')
@section('title', __('common.submitted.pictures'))

@section('head')
    <style>
        .moderation-rules {
            border: 2px solid #FF002E;
            border-radius: 5px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            padding: 15px;
            width: fit-content;
            justify-content: center;
            margin-left: 20%;
            margin-top: 10px;
            animation: pulse 2s infinite; /* Apply pulse animation */
        }

        @keyframes pulse {
            0% {
                border-color: #FF002E;
                box-shadow: 0 0 0 0 rgba(255, 0, 46, 0.7);
            }
            50% {
                border-color: #FF002E;
                box-shadow: 0 0 0 10px rgba(255, 0, 46, 0);
            }
            100% {
                border-color: #FF002E;
                box-shadow: 0 0 0 0 rgba(255, 0, 46, 0);
            }
        }

        .moderation-icon {
            color: #e57373;
            font-size: 24px;
            margin-right: 10px;
        }

        .moderation-text p {
            margin-bottom: 5px;
            color: #fff;
        }

        .moderation-text small {
            color: #bbb;
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 768px) {
            .moderation-rules {
                width: 90%; /* Adjust width for smaller screens */
                max-width: 300px; /* Adding max-width for better responsiveness */
                margin-left: auto; /* Center the element horizontally */
                margin-right: auto; /* Center the element horizontally */
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-event">
        <div class="header">
            <h3>{{ __('common.submitted.pictures') }}</h3>
        </div>

        <form id="upload-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="event-select">{{ __('common.select.events') }}</label>
                <select class="form-control" id="event-select" name="event"
                        form="upload-form" {{ $events->isEmpty() ? 'disabled' : '' }}>
                    @if($events->isEmpty())
                        <option>{{ __('common.select.no_events') }}</option>
                    @else
                        <option>{{ __('common.select.event') }}</option>
                    @endif
                    @foreach($events as $event)
                            <option value="{{ $event->event_id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="upload-box">
                    <label for="image-upload" class="upload-box-label">{{ __('common.select.upload') }}</label>
                    <input type="file" class="upload-box-input" id="image-upload" name="images[]"
                           accept="image/png, image/jpeg" multiple {{ $events->isEmpty() ? 'disabled' : '' }}>
                </div>
            </div>
            <div id="upload-previews"></div>
            <button type="submit" class="btn" {{ $events->isEmpty() ? 'disabled' : '' }}>{{ __('common.select.submit') }}</button>
        </form>

        <div class="moderation-rules">
            <div class="moderation-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="moderation-text">
                <!-- Pravidla moderace: -->
                <!-- 1. Všechny příspěvky podléhají moderaci. -->
                <p>Všechny příspěvky podléhají moderaci.</p>
                <p>Není povolena NSFW obsahu.</p>
                <p>Není povolena homophobicke obsahu.</p>
                <p>Není povolena agresivni obsahu.</p>
                <p>Není povolena obsahu, který zraňuje/nebo obsahuje nenávist.</p>
                <small>Všechny NSFW obsah bude smazán a účet bude zakázán na webových stránkách / Discord serveru.</small>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#image-upload').change(function () {
                $('#upload-previews').empty();
                $.each(this.files, function (index, file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const preview = $('<img>').attr('src', event.target.result).addClass('upload-preview');
                        $('#upload-previews').append(preview);
                    };
                    reader.readAsDataURL(file);
                });
            });

            $('#upload-form').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                @if(!Cookie::has('api_token'))
                    toastr.error(`Prosím, přihlaste se znovu nebo zkuste znovu později`);
                    return;
                @endif

                let size = $('#image-upload')[0].files.length;
                let error_count = 0;
                let processed_count = 0;

                // Loop through each selected file and upload one by one
                $.each($('#image-upload')[0].files, function (index, file) {
                    const formData = new FormData();
                    formData.append('file', file);

                    $.ajax({
                        url: 'https://autumn.fluffici.eu/photos',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            const body = new FormData();
                            body.append('attachment_id', response.id);
                            body.append('event_id', $('#event-select').val());

                            $.ajax({
                                url: 'https://api.fluffici.eu/api/event/submit-picture',
                                type: 'POST',
                                data: body,
                                headers: {
                                    'Authorization': `Bearer {{ Cookie::get('api_token') }}`
                                },
                                contentType: false,
                                processData: false,
                                success: function () {
                                    console.log(`'${response.id}#${index}': batch uploaded.`);
                                    processed_count++;
                                },
                                error: function () {
                                    toastr.error(`Při nahrávání indexu '${index}' došlo k chybě`);
                                    error_count++;
                                    processed_count++;
                                },
                                complete: function() {
                                    completeHandler(size, error_count, processed_count);
                                },
                            });
                        },
                        error: function () {
                            toastr.error(`Při nahrávání indexu '${index}' došlo k chybě`);
                            error_count++;
                            processed_count++;

                            completeHandler(size, error_count, processed_count);
                        },
                    });
                });
            });

            function completeHandler(size, error_count, processed_count) {
                if (processed_count === size) {
                    if (error_count === 0) {
                        toastr.success(`Všechny soubory byly úspěšně nahrány`);
                    } else {
                        toastr.error(`${error_count} souborů se nepodařilo nahrát`);
                        console.log(`${error_count} files failed to upload.`);
                    }
                    $('#image-upload').val('');
                }

                window.location.href = '{{ env('PUBLIC_URL') }}'
            }
        });
    </script>
@endsection
