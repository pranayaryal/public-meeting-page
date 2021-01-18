<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Registration;
use App\Jobs\SendEmailJob;
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

    $registrations = Registration::where([
      'meeting_id' => $meetingId
    ])->get();

    return \Inertia\Inertia::render('Meetings/Show', [
      'meeting' => $meeting,
      'registrations' => $registrations
    ]);
  }

  public function registrations($meetingId)
  {
    $registrations = Registration::where([
      'meeting_id' => $meetingId
    ])->get();

    if (count($registrations) != 0) {
      return json_encode([
        'registrations' => $registrations
      ]);
    }
    return json_encode([
      'registrations' => false
    ]);
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

    $meeting = Meeting::find($registration->meeting_id);
    $title = $meeting->title;
    $start = $meeting->start;


    $details = [
      'email' => $registration->email,
      'name' => $registration->name,
      'title' => $title,
      'start' => $start->format('Y M d @ H:i')
    ];

    SendEmailJob::dispatch($details);

    return json_encode([
      'registration' => $registration,
      'success' => true
    ]);
  }

}
