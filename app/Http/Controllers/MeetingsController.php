<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;

class MeetingsController extends Controller
{
    public function index()
    {
        $meetings = Meeting::all();

        return \Inertia\Inertia::render('Meetings/List', [
          'meetings' => $meetings
        ]);

    }

    public function show($meetingId)
    {
        $meeting = Meeting::find($meetingId);

        return \Inertia\Inertia::render('Meetings/Show', [
          'meeting' => $meeting
        ]);

    }

    public function showPublic($meetingId)
    {
        $meeting = Meeting::find($meetingId);
        return \Inertia\Inertia::render('Meetings/Show', [
          'meeting' => $meeting
        ]);
    }

    public function register(Request $request)
    {

        $request->validateWithBag('postMeetingForm', [
        'email' => 'required|email:rfc,dns',
        'name' => 'required|string',
        'title' => 'required|string',
        'rsvp' => 'required|string',
        'agenda' => 'required|string',
        'meeting_id' => 'required|integer',
        'show' => 'required|boolean'

    ]);

    return Redirect::route('public.show');
         
    }
}
