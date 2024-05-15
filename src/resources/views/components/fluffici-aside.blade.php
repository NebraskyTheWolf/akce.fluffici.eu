@php use App\Models\Subscriptions;use Illuminate\Support\Facades\Auth; @endphp
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('outings') }}"><img
                src="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" alt="header"
                width="210" class="sidebar-brand"></a>
    </div>
    <div class="sidebar-nav">
        <h2>{{ __('common.schedules') }}</h2>
        <ul>
            <li class="{{ request()->routeIs('outings') ? 'active' : '' }}"><a href="{{ route('outings') }}"><i
                        class="fas fa-home"></i> {{ __('common.outings') }}</a></li>
            <li class="{{ request()->routeIs('online-events') ? 'active' : '' }}"><a
                    href="{{ route('online-events') }}"><i class="fas fa-calendar-alt"></i> {{ __('common.online') }}
                </a></li>
        </ul>
    </div>

    @if(Auth::check())
        <div class="sidebar-nav">
            <h2>{{ __('common.profile') }}</h2>
            <ul>
                <li class="{{ request()->routeIs('profile.photos') ? 'active' : '' }}"><a
                        href="{{ route('profile.photos') }}"><i class="fas fa-cog"></i> {{ __('common.photos') }}</a>
                </li>
                <li class="{{ request()->routeIs('profile.reports') ? 'active' : '' }}"><a
                        href="{{ route('profile.reports') }}"><i class="fas fa-cog"></i> {{ __('common.reports') }}</a>
                </li>
            </ul>
        </div>

        <div class="sidebar-profile-card">
            @if (Auth::user()->avatar !== 1)
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff"
                     alt="Profile Picture" width="50">
            @else
                <img src="https://autumn.fluffici.eu/avatars/{{ Auth::user()->avatar_id }}" alt="Profile Picture"
                     width="50">
            @endif

            <p style="color: #fff">{{ Auth::user()->name }}</p>
            <a class="logout-btn" href="https://account.fluffici.eu">{{ __('common.account') }}</a>
        </div>

        <a class="logout-btn" href="{{ route('profile.logout') }}">{{ __('common.logout') }}</a>

        @if(Subscriptions::where('user_id', Auth::id())->exists())
            @if(Subscriptions::where('user_id', Auth::id())->first()->is_subscribed === 1)
                <a class="subscribe" href="{{ route('notification.subscribes') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bell-icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" stroke-width="0" fill="currentColor" />
                        <path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" stroke-width="0" fill="currentColor" />
                    </svg>
                </a>
            @else
                <a class="subscribe" href="{{ route('notification.subscribes') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="bell-icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                </a>
            @endif
        @else
            <a class="subscribe" href="{{ route('notification.subscribes') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="bell-icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                </svg>
            </a>
        @endif
    @else
        <a class="logout-btn" href="{{ app('authSDK')->getAuthURL() }}">{{ __('common.login') }}</a>
    @endif
</aside>
