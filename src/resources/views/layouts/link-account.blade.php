@extends("index")
@section('title', __('title.link-account'))

@section('head')
    <style>
        .platforms {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .platform {
            background-color: #1A1F1F;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            height: 350px;
            text-align: center;
            border: 2px solid transparent;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }
        .platform img {
            width: 108px;
            height: 108px;
            margin: auto;
        }
        .platforms a {
            text-decoration: none;
            color: white;
        }

        .platform.linked {
            border-color: #55ff6d;
        }

        .platform.unlinked {
            border-color: #ff003b;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .dot.linked {
            background-color: #55ff6d;
            animation: pulse 1.5s infinite;
        }

        .platforms .platform:hover {
            transform: scale(1.05);
        }

        .dot.unlinked {
            background-color: #ff003b;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(85, 255, 109, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(85, 255, 109, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(85, 255, 109, 0);
            }
        }

        strong {
            color: white;
            text-shadow: 2px 2px 4px #000000;
            font-family: "Lexend Deca", sans-serif;
            font-size: x-large;
        }

        h2 {
            color: white;
            font-family: "Luckiest Guy";
        }

        p {
            color: white;
        }

        /* Smartphone specific CSS */
        @media (max-width: 600px) {
            body {
                height: auto;
                padding: 20px 0;
            }

            .platforms {
                flex-direction: column;
                align-items: center;
            }

            .platform {
                width: 90%;
                height: auto;
                padding: 10px;
                margin: 10px 0;
            }

            .platform img {
                width: 80px;
                height: 80px;
            }

            h2 {
                font-size: 1.5em;
            }

            strong {
                font-size: large;
            }

            p {
                font-size: 0.9em;
            }

            .dot.help {
                width: 20px;
                height: 20px;
                background-color: orange;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                color: white;
                margin-left: 10px;
                cursor: pointer;
                animation: pulse-help 1.5s infinite;
            }
            @keyframes pulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(85, 255, 109, 0.7);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(85, 255, 109, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(85, 255, 109, 0);
                }
            }
            @keyframes pulse-help {
                0% {
                    box-shadow: 0 0 0 0 rgba(255, 165, 0, 0.7);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(255, 165, 0, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(255, 165, 0, 0);
                }
            }

            .form-container {
                display: none;
                background-color: #1A1F1F;
                border-radius: 10px;
                padding: 20px;
                width: 90%;
                max-width: 400px;
                text-align: center;
                margin-top: 20px;
            }

            .form-container input {
                width: calc(100% - 40px);
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .form-container button {
                padding: 10px 20px;
                background-color: #00ff6d;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                color: #1e1e1e;
                font-size: 16px;
            }

            .form-container button:hover {
                background-color: #55ff6d;
            }

            .tooltip {
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #1A1F1F;
                color: white;
                padding: 10px;
                border-radius: 5px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 10;
            }

            .tooltip::after {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                margin-left: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: #333 transparent transparent transparent;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-event">
        <div class="header">
            <h3 id="title">{{ __('common.link-account.title') }}</h3>
        </div>

        <div class="platforms">
            <a class="platform discord {{ $discord['status'] }}" href="{{ $discord['status'] == 'linked' ? 'https://api.fluffici.eu/api/user/@me/discord/unlink' : 'https://api.fluffici.eu/api/user/@me/discord/login' }}">
                <div class="dot {{ $discord['status'] == 'linked' ? 'linked' : 'unlinked' }}"></div>
                <img src="{{ url('/img/discord.png') }}" alt="Discord">
                <h2>Discord</h2>
                @if($discord['status'] == 'linked')
                    <p>Připojen jako:<br><strong>@{{ $discord->username }}</strong></p>
                @else
                    <p>{{ __('common.discord.unlinked') }}</p>
                @endif
            </a>
            <div id="telegram" class="platform telegram {{ $telegram['status'] }}">
                <div class="dot {{ $telegram['status'] }}"></div>
                <img src="{{ url('/img/telegram.png') }}" alt="Telegram">
                <h2>Telegram</h2>
                @if($telegram['status'] == 'linked')
                    <p>Připojen jako:<br><strong>@{{ $telegram->username }}</strong></p>
                @else
                    <p>{{ __('common.telegram.unlinked') }}</p>
                @endif
            </div>
        </div>

        <div class="form-container">
            <h3>Link your Telegram account</h3>
            <form>
                <input type="text" name="verification_code" placeholder="Verification Code" required>
                <button type="submit">Next</button>
                <div class="dot help">?</div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.form-container').hide();

            if ($('#telegram').hasClass('unlinked')) {
                $('.platforms').hide();
                $('.form-container').show();
            }

            $('#title').text('{{__('common.telegram.setup')}}')

            $('.dot.help').hover(function() {
                $(this).append('<div class="tooltip">{{ __('common.help.telegram.verification_code') }}</div>');
            }, function() {
                $('.tooltip').remove();
            });
        });
    </script>
@endsection
