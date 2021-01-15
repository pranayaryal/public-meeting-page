<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Registration;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

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

        $registrations = $this->getRegistrations($meetingId);

        return \Inertia\Inertia::render('Meetings/Show', [
          'meeting' => $meeting,
          'registrations' => $registrations
        ]);
    }

    public function getRegistrations($meetingId)
    {
        $registration = Registration::where([
          'meeting_id' => $meetingId
        ])->get();

        return $registration;

    }

    public function register(Request $request)
    {

        $registration = new Registration();
        $registration->email = $request->email;
        $registration->name = $request->name;
        $registration->rsvp = $request->rsvp;
        $registration->agenda_items = $request->agenda;
        $registration->meeting_id = $request->meeting_id;
        $registration->show_public = $request->show;

        $registration->save();

        $meeting = Meeting::find($request->meeting_id);
        $registrations = $this->getRegistrations($request->meeting_id);

        return json_encode([
          'registrations' => $registrations,
          'meeting' => $meeting
        ]);
    }





}
