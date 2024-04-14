<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimeTableResource;

use App\Models\Timetable;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Retrieve the authenticated user's ID and account type
        $userId = auth()->user()->id;
        $userAccountType = auth()->user()->account_type;

        // If the user is a student, fetch only their timetables
        if ($userAccountType === 1) { // Assuming 1 represents a student account type
            $timetables = Timetable::where('user_id', $userId)->get();
        } else {
            // Fetch all timetables
            $timetables = Timetable::all();
        }

        // return $timetables;
        return TimeTableResource::collection($timetables);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "create tables";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'venue' => 'required',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $existingEntry = Timetable::where('user_id', $userId)
            ->where('course_id', $request->course_id)
            ->where('venue', $request->venue)
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->exists();

        if ($existingEntry) {
            return response()->json([
                'status' => false,
                'message' => 'This timetable entry already exists for the you.'
            ], 400);
        }

        $existingDay = Timetable::where('user_id', $userId)
            ->where('course_id', $request->course_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($existingDay) {
            return response()->json([
                'status' => false,
                'message' => 'You already have already blocked this period on the time table.'
            ], 401);
        }

        // Add the authenticated user's ID to the request data
        $requestData = $request->all();
        $requestData['user_id'] = $userId;

        $timetable = Timetable::create($requestData);

        return response()->json($timetable, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showByCourseId($courseId)
    {
        // Retrieve the authenticated user's ID
        $userId = auth()->user()->id;

        // Fetch timetables by course ID for the authenticated user
        $timetables = Timetable::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->get();

        // Check if any timetables were found
        if ($timetables->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No timetables found for the specified course ID.'
            ], 404);
        }

        return response()->json($timetables, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
