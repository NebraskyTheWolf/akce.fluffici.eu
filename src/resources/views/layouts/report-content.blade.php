@extends('index')
@section('title', __('common.report.content'))

@section('style')
    <style>
        .container-report {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1a1c1c;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Lexend Deca', sans-serif;
            color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-family: 'Lexend Deca', sans-serif;
            color: #fff;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            resize: vertical;
        }

        textarea.form-control {
            min-height: 150px;
            max-height: 300px;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Select Menu */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper:after {
            content: "\f107";
            font-family: FontAwesome;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #fff;
            pointer-events: none;
        }

        .select-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            cursor: pointer;
            background-image: linear-gradient(45deg, transparent 50%, #fff 50%), linear-gradient(135deg, #fff 50%, transparent 50%);
            background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 15px) calc(1em + 2px);
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
        }

        textarea#report-message {
            width: 100%;
            height: 150px;
            padding: 20px;
            box-sizing: border-box;
            border: none;
            border-radius: 8px;
            background-color: #fafafa;
            box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.15);
            font-size: 18px;
            font-family: 'Roboto', sans-serif;
            transition: all 0.3s ease;
            resize: none;
        }

        textarea#report-message::placeholder {
            color: #999;
        }

        textarea#report-message:focus {
            outline: none;
            box-shadow: 0px 2px 5px 0px rgba(66, 133, 244, 0.3);
        }
    </style>
@endsection

@section('content')
    <div class="container-event">
        <div class="container-report">
            <h2 class="report-title" style="padding: 10px; color: #fff;">{{ __('common.report.content') }}</h2>
            <form id="report-form" enctype="multipart/form-data" method="POST" action="{{ route('report.push') }}">
                @csrf
                <label>
                    <input hidden="" type="text" value="{{ $attachment }}" name="attachment_id">
                </label>

                <div class="form-group">
                    <label for="report-category">Category:</label>
                    <div class="select-wrapper">
                        <select class="form-control" id="report-category" name="category" form="report-form" required>
                            <option value="inappropriate">Inappropriate Content (NSFW)</option>
                            <option value="copyright">Copyright Violation (DMCA)</option>
                            <option value="spam">Spam or Misleading</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="report-message">Message:</label>
                    <textarea class="form-control" id="report-message" name="message" rows="10" cols="165"
                              placeholder="Write your report here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        </div>
    </div>
@endsection
