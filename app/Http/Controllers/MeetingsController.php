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
}
