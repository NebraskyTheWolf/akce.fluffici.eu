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

        @keyframes pulseUniversal {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 0, 46, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(255, 0, 46, 0);
            }
            100% {
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

        .progress-bar {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .progress-bar {
            height: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2px;
            border: 1px solid rgb(26, 28, 31);
        }

        .progress__bar {
            display: block;
            position: relative;
            top: -1px;
            left: -1px;
            width: 0%;
            opacity: 1;
            border-radius: 2px 0 0 2px;
            background-size: 100px 30px, 130px 30px, 130px 30px;
            background-position: -20% center, right center, left center;
            background-repeat: no-repeat, no-repeat, no-repeat;
            transition: opacity 0.2s ease, width 0.8s ease-out, background-color 1s ease, border-color 0.3s ease, box-shadow 1s ease;
            animation: pulseBar 2s ease-out infinite;
            background-color: rgba(18, 135, 204, 0.95);
            background-image: linear-gradient(90deg, rgba(20, 151, 227, 0) 10%, rgba(37, 162, 236, 0.8) 30%, #3dacee 70%, rgba(37, 162, 236, 0.8) 80%, rgba(20, 151, 227, 0) 90%), linear-gradient(to right, rgba(61, 172, 238, 0) 0%, #3dacee 100%), linear-gradient(to left, rgba(61, 172, 238, 0) 0%, #3dacee 100%);
            border: 1px solid #54b6f0;
            box-shadow: 0 0 0.6em #25a2ec inset, 0 0 0.4em #1497e3 inset, 0 0 0.5em rgba(18, 135, 204, 0.5), 0 0 0.1em rgba(225, 242, 252, 0.5);
        }
        .progress__bar:before, .progress__bar:after {
            content: "";
            position: absolute;
            height: 40px;
        }

        .progress__bar--orange {
            background-color: rgba(201, 47, 0, 0.95);
            background-image: linear-gradient(90deg, rgba(227, 53, 0, 0) 10%, rgba(252, 59, 0, 0.8) 30%, #ff4d17 70%, rgba(252, 59, 0, 0.8) 80%, rgba(227, 53, 0, 0) 90%), linear-gradient(to right, rgba(255, 77, 23, 0) 0%, #ff4d17 100%), linear-gradient(to left, rgba(255, 77, 23, 0) 0%, #ff4d17 100%);
            border-color: #ff6030;
            box-shadow: 0 0 0.6em #fc3b00 inset, 0 0 0.4em #e33500 inset, 0 0 0.5em rgba(201, 47, 0, 0.5), 0 0 0.1em rgba(255, 214, 201, 0.5);

            animation: pulseUniversal 2s infinite;
        }
        .progress__bar--yellow {
            background-color: rgba(232, 158, 0, 0.95);
            background-image: linear-gradient(90deg, rgba(255, 174, 3, 0) 10%, rgba(255, 183, 28, 0.8) 30%, #ffbf36 70%, rgba(255, 183, 28, 0.8) 80%, rgba(255, 174, 3, 0) 90%), linear-gradient(to right, rgba(255, 191, 54, 0) 0%, #ffbf36 100%), linear-gradient(to left, rgba(255, 191, 54, 0) 0%, #ffbf36 100%);
            border-color: #ffc74f;
            box-shadow: 0 0 0.6em #ffb71c inset, 0 0 0.4em #ffae03 inset, 0 0 0.5em rgba(232, 158, 0, 0.5), 0 0 0.1em rgba(255, 248, 232, 0.5);

            animation: pulseUniversal 2s infinite;
        }
        .progress__bar--green {
            background-color: rgba(0, 178, 23, 0.95);
            background-image: linear-gradient(90deg, rgba(0, 204, 26, 0) 10%, rgba(0, 229, 30, 0.8) 30%, #00ff21 70%, rgba(0, 229, 30, 0.8) 80%, rgba(0, 204, 26, 0) 90%), linear-gradient(to right, rgba(0, 255, 33, 0) 0%, #00ff21 100%), linear-gradient(to left, rgba(0, 255, 33, 0) 0%, #00ff21 100%);
            border-color: #19ff37;
            box-shadow: 0 0 0.6em #00e51e inset, 0 0 0.4em #00cc1a inset, 0 0 0.5em rgba(0, 178, 23, 0.5), 0 0 0.1em rgba(178, 255, 188, 0.5);

            animation: pulseUniversal 2s infinite;
        }
        .progress__bar--blue {
            background-color: rgba(18, 135, 204, 0.95);
            background-image: linear-gradient(90deg, rgba(20, 151, 227, 0) 10%, rgba(37, 162, 236, 0.8) 30%, #3dacee 70%, rgba(37, 162, 236, 0.8) 80%, rgba(20, 151, 227, 0) 90%), linear-gradient(to right, rgba(61, 172, 238, 0) 0%, #3dacee 100%), linear-gradient(to left, rgba(61, 172, 238, 0) 0%, #3dacee 100%);
            border-color: #54b6f0;
            box-shadow: 0 0 0.6em #25a2ec inset, 0 0 0.4em #1497e3 inset, 0 0 0.5em rgba(18, 135, 204, 0.5), 0 0 0.1em rgba(225, 242, 252, 0.5);

            animation: pulseUniversal 2s infinite;
        }

        @keyframes pulseBar {
            0% {
                background-position: -50% center, right center, left center;
            }
            100% {
                background-position: 150% center, right center, left center;
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

            <div id="progress-bar-container" class="progress-bar progress__bar progress__bar--blue" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>

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
                <p>{{ __('rules.one') }}</p>
                <p>{{ __('rules.two') }}</p>
                <p>{{ __('rules.three') }}</p>
                <p>{{ __('rules.four') }}</p>
                <p>{{ __('rules.five') }}</p>
                <small>{{ __('rules.six') }}</small>
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

                const files = $('#image-upload')[0].files;
                const totalFiles = files.length;
                let errorCount = 0;
                let processedCount = 0;

                let broken = false

                // Loop through each selected file and upload one by one
                $.each(files, function (index, file) {
                    const formData = new FormData();
                    formData.append('file', file);

                    if (broken)
                        return;

                    // Create progress bar for this file
                    const progressBar = $('#progress-bar-container');

                    $.ajax({
                        url: 'https://autumn.fluffici.eu/photos',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    const datasetPercent = (processedCount * 100) / totalFiles;
                                    const currentFilePercent = (evt.loaded * 100) / evt.total;
                                    const percentComplete = datasetPercent + (currentFilePercent / totalFiles);

                                    progressBar.css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
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
                                    processedCount++;
                                },
                                error: function () {
                                    toastr.error(`{{ __('common.upload.error') }}`);
                                    errorCount++;
                                    processedCount++;

                                    broken = true
                                    progressBar.removeClass('.progress__bar--blue').addClass('progress__bar--orange')
                                },
                                complete: function() {
                                    completeHandler(totalFiles, errorCount, processedCount);
                                },
                            });
                        },
                        error: function (result) {
                            errorCount++;
                            processedCount++;

                            broken = true
                            progressBar.removeClass('.progress__bar--blue').addClass('progress__bar--orange')

                            openErrorModal(result)
                        },
                    });
                });
            });

            function completeHandler(totalFiles, errorCount, processedCount) {
                if (processedCount === totalFiles) {
                    if (errorCount === 0) {
                        //Všechny soubory byly úspěšně nahrány
                        toastr.success(`{{ __('common.upload.success') }}`);
                    } else {
                        toastr.error(`{{ __('common.upload.error') }}`);
                        console.log(`${errorCount} files failed to upload.`);
                    }
                    $('#image-upload').val('');
                }

                setTimeout(() => {
                    window.location.href = '{{ env('PUBLIC_URL') }}/event?id=' + $('#event-select').val()
                }, 1000 * 5)
            }

            // Function to open error modal with message
            function openErrorModal(message) {
                toastr.error(getMessageFromError(message));
            }

            function getMessageFromError(result) {
                if (result.type === "Malware") {
                    return '{{ __('autumn.malware') }}'
                } else if (result.type === "S3Error") {
                    return '{{ __('autumn.aws_error') }}'
                } else if (result.type === "DatabaseError") {
                    return '{{ __('autumn.database_error') }}'
                } else if (result.type === "FileTypeNotAllowed") {
                    return '{{ __('autumn.not_allowed') }}'
                } else if (result.type === "UnknownTag") {
                    return '{{ __('autumn.unknown_tag') }}'
                } else if (result.type === "MissingData") {
                    return '{{ __('autumn.missing_data') }}'
                } else if (result.type === "FailedToReceive") {
                    return '{{ __('autumn.failed_to_receive') }}'
                } else if (result.type === "FileTooLarge") {
                    return '{{ __('autumn.file_too_large') }}'
                } else if (result.type === "BlockingError") {
                    return '{{ __('autumn.nsfw') }}'
                } else {
                    return '{{ __('autumn.unknown') }}'
                }
            }
        });
    </script>
@endsection
