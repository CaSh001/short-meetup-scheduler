<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Requests\UpdateAvailabilityRequest;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('availabilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvailabilityRequest $request)
    {
        $data = $request->validated();
        //$this->authorize('modify', Availability::class); //Who should be able to modify this meeting?
        $user = auth()->user();
        $meeting = Meeting::find($data['meeting_id']);
        $meeting->availabilities()->create($data);

        return redirect()->route('meetings.show', ['meeting' => $meeting->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Availability $availability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Availability $availability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvailabilityRequest $request, Availability $availability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        //
    }
}
