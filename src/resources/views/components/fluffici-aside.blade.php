@php use Illuminate\Support\Facades\Auth; @endphp
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('outings') }}"><img src="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" alt="header" width="210" class="sidebar-brand"></a>
    </div>
    <div class="sidebar-nav">
        <h2>{{ __('common.schedules') }}</h2>
        <ul>
            <li class="{{ request()->routeIs('outings') ? 'active' : '' }}"><a href="{{ route('outings') }}"><i class="fas fa-home"></i> {{ __('common.outings') }}</a></li>
            <li class="{{ request()->routeIs('online-events') ? 'active' : '' }}"><a href="{{ route('online-events') }}"><i class="fas fa-calendar-alt"></i> {{ __('common.online') }}</a></li>
        </ul>
    </div>

    @if(Auth::check())
        <div class="sidebar-nav">
            <h2>{{ __('common.profile') }}</h2>
            <ul>
                <li class="{{ request()->routeIs('profile.photos') ? 'active' : '' }}"><a href="{{ route('profile.photos') }}"><i class="fas fa-cog"></i> {{ __('common.photos') }}</a></li>
                <li class="{{ request()->routeIs('profile.reports') ? 'active' : '' }}"><a href="{{ route('profile.reports') }}"><i class="fas fa-cog"></i> {{ __('common.reports') }}</a></li>
            </ul>
        </div>

        <div class="sidebar-profile-card">
            @if (Auth::user()->avatar !== 1)
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" alt="Profile Picture" width="50">
            @else
                <img src="https://autumn.fluffici.eu/avatars/{{ Auth::user()->avatar_id }}" alt="Profile Picture" width="50">
            @endif

            <p style="color: #fff">{{ Auth::user()->name }}</p>
        </div>
        <a class="logout-btn" href="{{ route('profile.logout') }}">{{ __('common.logout') }}</a>
    @else
        <a class="logout-btn" href="{{ app('authSDK')->getAuthURL() }}">{{ __('common.login') }}</a>
    @endif
</aside>
