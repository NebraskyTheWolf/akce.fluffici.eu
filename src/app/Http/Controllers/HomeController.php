<?php

namespace App\Http\Controllers;
use App\Models\EventAttachments;
use App\Models\Events;
use App\Models\ReportedAttachments;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function outings(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $incoming = Events::where('status', 'INCOMING')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'desc')
            ->get();
        $started = Events::where('status', 'STARTED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'desc')
            ->get();
        $finished = Events::where('status', 'ENDED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'desc')
            ->get();
        $cancelled = Events::where('status', 'CANCELLED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($incoming as $event) {
            $this->handleEvent($event);
        }

        foreach ($started as $event) {
            $this->handleEvent($event);
        }

        foreach ($finished as $event) {
            $this->handleEvent($event);
        }

        foreach ($cancelled as $event) {
            $this->handleEvent($event);
        }

        $title = __('common.outings');

        return view('layouts.trello', compact(
            'incoming',
            'started',
            'finished',
            'cancelled',
            'title'
        ));
    }

    public function onlineEvents(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $incoming = Events::where('status', 'INCOMING')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'desc')
            ->get();
        $started = Events::where('status', 'STARTED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'desc')
            ->get();
        $finished = Events::where('status', 'ENDED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'desc')
            ->get();
        $cancelled = Events::where('status', 'CANCELLED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($incoming as $event) {
            $this->handleEvent($event);
        }

        foreach ($started as $event) {
            $this->handleEvent($event);
        }

        foreach ($finished as $event) {
            $this->handleEvent($event);
        }

        foreach ($cancelled as $event) {
            $this->handleEvent($event);
        }


        $title = __('common.online');

        return view('layouts.trello', compact(
            'incoming',
            'started',
            'finished',
            'cancelled',
            'title'
        ));
    }

    public function akce(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $eventId = $request->query('id');
        $event = Events::where('event_id', $eventId)->firstOrFail();

        if ($event->startAt === null && $event->begin != null) {
            $start = Carbon::parse($event->begin);
            $event->startAt = $start->isoFormat('MMMM D, YYYY HH:mm');
        }

        if ($event->endAt === null && $event->end != null) {
            $end = Carbon::parse($event->end);
            $event->endAt = $end->isoFormat('MMMM D, YYYY HH:mm');
        }

        if ($event->banner_url === null) {
            $event->banner_url = $event->banner_id ? "https://autumn.fluffici.eu/banners/{$event->banner_id}?width=800&height=400" : "https://placehold.co/800x400";
        }

        if ($event->map_url === null && $event->map_id != null) {
            $event->map_url = "https://autumn.fluffici.eu/attachments/{$event->map_id}?width=620&height=300";
        }

        $pictures = EventAttachments::where('event_id', $event->event_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.event', compact(
            'event',
            'pictures'
        ));
    }

    public function profile(Request $request): RedirectResponse
    {
        return redirect()->route('outings');
    }

    public function submittedPictures(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        if (Auth::guest()) {
            toast()
                ->danger(__('common.login.required'))
                ->pushOnNextPage();

            return redirect()->route(app('authSDK')->getAuthURL());
        }

        $events = Events::where('status', "ENDED")
            ->orderby('created_at', 'desc')
            ->get();

        return view('layouts.submit-pictures', compact('events'));
    }

    public function submittedReports(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        if (Auth::guest()) {
            toast()
                ->danger(__('common.login.required'))
                ->pushOnNextPage();

            return redirect()->route(app('authSDK')->getAuthURL());
        }

        $reports = ReportedAttachments::where('email', $request->user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.submitted-reports', compact('reports'));
    }

    public function showReport(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {

        if (Auth::guest()) {
            toast()
                ->danger(__('common.login.required'))
                ->pushOnNextPage();

            return redirect()->route(app('authSDK')->getAuthURL());
        }

        $report = ReportedAttachments::where('id', $request->id)
            // Being sure that the report belongs to the logged user.
            ->where('email', $request->user()->email);

        if (!$report->exists()) {
            toast()
                ->success(__('common.report.not_found'))
                ->pushOnNextPage();

            return redirect()->route('outings');
        }

        return view('layouts.show-report', compact('report'));
    }

    public function reportContent(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        if (Auth::guest()) {
            toast()
                ->danger(__('common.login.required'))
                ->pushOnNextPage();

            return redirect()->route(app('authSDK')->getAuthURL());
        }

        $attachment = $request->query('attachment');
        return view('layouts.report-content', compact('attachment'));

    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->flush();
        Auth::logout();

        toast()
            ->success(__('common.logged.out'))
            ->pushOnNextPage();

        return redirect()->route('outings');
    }

    function handleEvent(object $event): void {
        if ($event->thumbnail === null && $event->thumbnail_id != null) {
            $event->thumbnail = "https://autumn.fluffici.eu/attachments/{$event->thumbnail_id}?width=600&height=300";
        } else if ($event->thumbnail === null) {
            $event->thumbnail = "https://placehold.co/600x300";
        }

        if ($event->startAt === null && $event->begin != null) {
            $start = Carbon::parse($event->begin);
            $event->startAt = $start->isoFormat('MMMM D, YYYY');
            $event->startAtTime = $start->isoFormat('HH:mm');
        }
    }
}
