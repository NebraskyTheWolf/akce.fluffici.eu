@php use Illuminate\Support\Facades\Auth; @endphp
@extends('index')
@section('title', __('common.submitted.pictures'))

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
                    @foreach($events as $event)
                        @if($events->isEmpty())
                            <option>{{ __('common.select.no_events') }}</option>
                        @else
                            <option>{{ __('common.select.event') }}</option>
                        @endif
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
            <button type="submit"
                    class="btn" {{ $events->isEmpty() ? 'disabled' : '' }}>{{ __('common.select.submit') }}</button>
        </form>
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
                            body.append('user_id', '{{ Auth::id() }}')

                            console.log(response.id)

                            $.ajax({
                                url: 'https://api.fluffici.eu/api/event/submit-picture',
                                type: 'POST',
                                data: body,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    const id = response.id;

                                    console.log(response.id)

                                    console.log(`Pictures batch ${id} successfully saved.`)
                                },
                                error: function (xhr, status, error) {
                                    alert('{{ __('common.select.cannot_save') }}')
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            alert('{{ __('common.select.cannot_send_to_server') }}')
                        }
                    });
                });
            });
        });
    </script>
@endsection
