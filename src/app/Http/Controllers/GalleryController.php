<?php

namespace App\Http\Controllers;

use App\Models\EventAttachments;
use App\Models\Events;
use App\Models\User;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function showGallery(Request $request) {
        $query = $request->input('query', '');
        $events = Events::where('status', 'ENDED')
            ->where('type', 'PHYSICAL')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'asc')
            ->paginate(6);

        foreach ($events as $event) {
            $picture = EventAttachments::where('event_id', $event->event_id)
                ->orderBy('created_at', 'asc');

            if ($picture->exists()) {
                $picture = $picture->first();

                if ($picture->user == null) {
                    $picture->user = User::where('id', $picture->user_id)->first();

                    if ($picture->user->avatar == 1) {
                        $picture->user->avatar = "https://autumn.fluffici.eu/avatars/" . $picture->user->avatar_id;
                    } else {
                        $picture->user->avatar = 'https://ui-avatars.com/api/?name=' . $picture->user->name . '&background=0D8ABC&color=fff';
                    }
                }

                $event->picture = $picture;
                $event->hasPictures = true;
            } else {
                $event->hasPictures = false;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'events' => $events->items(),
                'total_pages' => $events->lastPage(),
            ]);
        }

        $title = __('common.gallery');

        return view('layouts.gallery', compact('events', 'title'));
    }

    public function showAlbum(Request $request) {
        $eventId = $request->id;
        $event = Events::where('event_id', $eventId);

        if ($event->exists()) {
            $event = $event->first();
            $pictures = EventAttachments::where('event_id', $event->event_id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            foreach ($pictures as $picture) {
                $picture->user = User::where('id', $picture->user_id)->first();
                if ($picture->user->avatar == 1) {
                    $picture->user->avatar = "https://autumn.fluffici.eu/avatars/" . $picture->user->avatar_id;
                } else {
                    $picture->user->avatar = 'https://ui-avatars.com/api/?name=' . $picture->user->name . '&background=0D8ABC&color=fff';
                }

                $picture->metadata = [];
            }

            $event->pictures = $pictures;

            $title = __('common.gallery.title', [ 'name' => $event->name ]);

            return view('layouts.album', compact('event',  'pictures', 'title'));
        }  else {
            return redirct()->route('outings');
        }
    }
}
