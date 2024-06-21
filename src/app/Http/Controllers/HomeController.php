<?php

namespace App\Http\Controllers;
use App\Models\EventAttachments;
use App\Models\Events;
use App\Models\EventsInteresteds;
use App\Models\ReportedAttachments;
use App\Models\Subscriptions;
use App\Models\TelegramVerification;
use App\Models\TelegramVerified;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

/*
                            LICENCE PRO PROPRIETÁRNÍ SOFTWARE
              Verze 1, Organizace: Fluffici, z.s. IČO: 19786077, Rok: 2024
                            PODMÍNKY PRO POUŽÍVÁNÍ

    a. Použití: Software lze používat pouze podle přiložené dokumentace.
    b. Omezení reprodukce: Kopírování softwaru bez povolení je zakázáno.
    c. Omezení distribuce: Distribuce je povolena jen přes autorizované kanály.
    d. Oprávněné kanály: Distribuci určuje výhradně držitel autorských práv.
    e. Nepovolené šíření: Šíření mimo povolené podmínky je zakázáno.
    f. Právní důsledky: Porušení podmínek může vést k právním krokům.
    g. Omezení úprav: Úpravy softwaru jsou zakázány bez povolení.
    h. Rozsah oprávněných úprav: Rozsah úprav určuje držitel autorských práv.
    i. Distribuce upravených verzí: Distribuce upravených verzí je povolena jen s povolením.
    j. Zachování autorských atribucí: Kopie musí obsahovat všechny autorské atribuce.
    k. Zodpovědnost za úpravy: Držitel autorských práv nenese odpovědnost za úpravy.

    Celý text licence je dostupný na adrese:
    https://autumn.fluffici.eu/attachments/xUiAJbvhZaXW3QIiLMFFbVL7g7nPC2nfX7v393UjEn/fluffici_software_license_cz.pdf
*/

class HomeController extends Controller
{
    public function outings(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $incoming = Events::where('status', 'INCOMING')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'asc')
            ->get();
        $started = Events::where('status', 'STARTED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'asc')
            ->get();
        $finished = Events::where('status', 'ENDED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'asc')
            ->get();
        $cancelled = Events::where('status', 'CANCELLED')
            ->where('type', 'PHYSICAL')
            ->orderBy('created_at', 'asc')
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
            ->orderBy('created_at', 'asc')
            ->get();
        $started = Events::where('status', 'STARTED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'asc')
            ->get();
        $finished = Events::where('status', 'ENDED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'asc')
            ->get();
        $cancelled = Events::where('status', 'CANCELLED')
            ->where('type', 'ONLINE')
            ->orderBy('created_at', 'asc')
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

    public function akce(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $eventId = $request->query('id');
        $event = Events::where('event_id', $eventId);

        if (!$event->exists()) {
            return redirect()->route('outings')->with('flash.error', __('common.event.not_found'));
        }

        $event = $event->first();

        if ($event->startAt === null && $event->begin != null) {
            $start = Carbon::parse($event->begin);
            $event->startAt = $start->isoFormat('dddd, D. MMMM YYYY | HH:mm');
        }

        if ($event->endAt === null && $event->end != null) {
            $end = Carbon::parse($event->end);
            $event->endAt = $end->isoFormat('dddd, D. MMMM YYYY | HH:mm');
        }

        if ($event->banner_url === null) {
            $event->banner_url = $event->banner_id ? "https://autumn.fluffici.eu/banners/{$event->banner_id}?width=800&height=400" : "https://placehold.co/800x400";
        }

        if ($event->map_url === null && $event->map_id != null) {
            $event->map_url = "https://autumn.fluffici.eu/attachments/{$event->map_id}?width=620&height=300";
        }

        $description = $event->descriptions;
        $pattern = '#\[([^]]+)]\((https?://\S+)\)#';

        $callback = function($matches) {
            $title = $matches[1];
            $url = $matches[2];

            return '<a href="' . $url . '" style="color: blue; text-decoration: underline;">' . htmlspecialchars(strip_tags($title)) . '</a>';
        };

        $descriptionWithLinks = preg_replace_callback($pattern, $callback, $description);
        $event->descriptions = $descriptionWithLinks;

        $map = json_decode($event->min, true);
        $latitude = $map['lat'];
        $longitude = $map['lng'];

        $pictures = EventAttachments::where('event_id', $event->event_id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($pictures as $picture) {
            if ($picture->user == null) {
                $picture->user = User::where('id', $picture->user_id)->first();

                if ($picture->user->avatar == 1) {
                    $picture->user->avatar = "https://autumn.fluffici.eu/avatars/" . $picture->user->avatar_id;
                } else {
                    $picture->user->avatar = 'https://ui-avatars.com/api/?name=' . $picture->user->name . '&background=0D8ABC&color=fff';
                }
            }
        }

        return view('layouts.event', compact(
            'event',
            'pictures',
            'latitude',
            'longitude'
        ));
    }

    public function profile(Request $request): RedirectResponse
    {
        return redirect()->route('outings');
    }

    public function submittedPictures(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        if ($request->user()->discord_linked == 1) {
            if ($this->isDBVerified($request->user()->discord_id)) {
                $events = Events::where('status', "ENDED")
                    ->where('type', 'PHYSICAL')
                    ->orderby('created_at', 'desc')
                    ->get();

                return view('layouts.submit-pictures', compact('events'));
            } else {
                return redirect()->route('outings')->with('flash.error', __('common.verification.required'));
            }
        } else {
            return redirect()->route('outings')->with('flash.error', __('common.discord.required'));
        }
    }

    public function isDBVerified(string $snowflake): bool
    {
        $response = \Httpful\Request::get("https://frdbapi.fluffici.eu/api/users/" . $snowflake . '/is-verified')->expectsJson()->send();

        if ($response->code === 200) {
            $body = json_decode(json_encode($response->body), true);
            return boolval($body['data']['verified']);
        }

        return false;
    }


    public function submittedReports(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $reports = ReportedAttachments::where('email', $request->user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.submitted-reports', compact('reports'));
    }

    public function showReport(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {

        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $report = ReportedAttachments::where('id', $request->id)
            ->where('email', $request->user()->email);

        if (!$report->exists()) {
            return redirect()->route('outings')->with('flash.error', __('common.report.not_found'));
        }

        $report = $report->first();

        if ($report->type == 'NOTHING') {
            $report->type = "Po vyšetření jsme zjistili, že váš případ neoprávnění odstranění tohoto obsahu.";
        } else if ($report->type == 'DELETE') {
            $report->type = "Rozhodli jsme se odstranit obsah, který jste nahlásili.";
        } else if ($report->type == 'REPORT') {
            $report->type = "Rozhodli jsme se trvale odstranit obsah, který jste nahlásili.";
        }

        return view('layouts.show-report', compact('report'));
    }

    public function reportContent(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $attachment = $request->query('attachment');
        return view('layouts.report-content', compact('attachment'));
    }

    public function pushReport(Request $request): RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $attachment = $request->input('attachment_id');
        $category = $request->input('category');
        $message = $request->input('message');

        $report = new ReportedAttachments();
        $report->reason = ucwords($category) . ': ' . $message;
        $report->email = $request->user()->email;
        $report->username = $request->user()->name;
        $report->isLegalPurpose = false;
        $report->attachment_id = $attachment;
        $report->reviewed = 0;
        $report->save();

        return redirect()->route('outings')
            ->with('flash.success', __('common.report.success'));
    }

    public function subscribeNotification(Request $request): RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $subscription = Subscriptions::where('user_id', $request->user()->id);
        if ($subscription->exists()) {
            $subscription = $subscription->first();

            if ($subscription->is_subscribed == 1) {
                $subscription->update(['is_subscribed' => 0]);

                return redirect()->route('outings')
                    ->with('flash.info', __('common.unsubscribe.success'));
            } else {
                $subscription->update(['is_subscribed' => 1]);

                return redirect()->route('outings')
                    ->with('flash.info', __('common.subscribe.success'));
            }
        } else {
            $subscription = new Subscriptions();
            $subscription->user_id = $request->user()->id;
            $subscription->is_subscribed = 1;
            $subscription->save();

            return redirect()->route('outings')
                ->with('flash.success', __('common.subscribe.success'));
        }
    }

    public function markInterested(Request $request): RedirectResponse {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $eventId = $request->eventId;

        $event = Events::where('event_id', $eventId);
        if (!$event->exists()) {
            return redirect()->route('outings')->with('flash.error', __('common.event.not_found'));
        }

        $event = $event->first();

        $interested = new EventsInteresteds();
        $interested->event_id = $event->event_id;
        $interested->username = $request->user()->name;
        $interested->save();

        return redirect()->route('outings')
            ->with('flash.success', __('common.interest.success'));
    }

    public function linkAccount(Request $request) {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $discord = [];
        $discord['status'] = $request->user()->discord_linked == 1 ? 'linked' : 'unlinked';
        $discord['username'] = $request->user()->username;

        $verification = TelegramVerified::where('fluffici_id', $request->user()->id);


        $telegram = [];
        $telegram['status'] = $verification->exists() ? 'linked' : 'unlinked';
        $telegram['username'] = $verification->username;

        return view('layouts.link-account', compact('discord', 'telegram'));
    }

    public function linkTelegram(Request $request) {
        if (Auth::guest()) {
            return redirect()->route('outings')->with('flash.error', __('common.login.required'));
        }

        $verification = TelegramVerification::where('verification_code', $request->input('verification_code'));

        if ($verification->exists()) {
            $verification->status = 'VERIFIED';
            $verification->save();

            $verifiedUser = new TelegramVerified();
            $verifiedUser->user_id = $verification->user_id;
            $verifiedUser->username = $verification->username;
            $verifiedUser->fluffici_id = $request->user()->id;
            $verifiedUser->save();

            return redirect()->route('link-account');
        } else {
            return throw ValidationException::withMessages([
                'verification_code' => __('common.verification_code.invalid'),
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse {
        $request->session()->flush();
        Auth::logout();

        return redirect()->route('outings')->with('flash.error', __('common.login.logged_out'));
    }

    function handleEvent(object $event): void {
        if ($event->thumbnail === null && $event->thumbnail_id != null) {
            $event->thumbnail = "https://autumn.fluffici.eu/attachments/{$event->thumbnail_id}?width=600&height=300";
        } else if ($event->thumbnail === null) {
            $event->thumbnail = "none";
        }

        $description = $event->descriptions;
        $pattern = '#\[([^]]+)]\((https?://\S+)\)#';

        $callback = function($matches) {
            $title = $matches[1];
            $url = $matches[2];

            return '<a href="' . $url . '" style="color: blue; text-decoration: underline;">' . htmlspecialchars(strip_tags($title)) . '</a>';
        };

        $descriptionWithLinks = preg_replace_callback($pattern, $callback, $description);

        if (strlen($descriptionWithLinks) > 300) {
            $event->descriptions = substr($descriptionWithLinks, 0, 300);
            $event->descriptions .= '  <span style="font-family: Arial, sans-serif; font-size: 16px; color: #FF002E; font-weight: bold;"> ≫ Číst dále...</span>';
        } else {
            $event->descriptions = $descriptionWithLinks;
        }

        if ($event->startAt === null && $event->begin != null) {
            $start = Carbon::parse($event->begin);
            $event->startAt = $start->isoFormat('MMMM D, YYYY');
            $event->startAtTime = $start->isoFormat('HH:mm');
        }
    }
}
