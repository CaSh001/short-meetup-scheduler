<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use Illuminate\Http\Request;


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $meetings = $user->meetings()->withCount('availabilities')->get();
    
        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$this->authorize('create', Book::class); //Should only logged-in users create meetings?
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeetingRequest $request)
    {
        $data = $request->validated();
        //$this->authorize('modify', Meeting::class); //Who should be able to modify this meeting?
        $user = auth()->user();
        $meeting = $user->meetings()->create($data);

        return redirect()->route('meetings.show', ['meeting' => $meeting->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $hours = range(0, 23);

        return view('meetings.show', ['meeting' => $meeting, 'days' => $days, 'hours' => $hours]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        //
    }

    public function updateFinalizedTime(Request $request)
    {
        $day = $request->input('day');
        $hour = $request->input('hour');
        $meetingId = $request->input('meetingId');

        // Find the meeting by ID
        $meeting = Meeting::findOrFail($meetingId);

        // Update the "finalized time" in the model
        $meeting->finalized_time = "$day, $hour";
        $meeting->save();

        return response()->json(['success' => true]);
    }
}
