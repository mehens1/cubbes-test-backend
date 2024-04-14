<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\CourseResource;
use App\Models\Course;

class CourseController extends Controller
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
            $course = Course::where('user_id', $userId)->get();
        } else {
            // Fetch all timetables
            $course = Course::all();
        }

        return $course;
    }

    public function showMyCourse()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Assuming you have relationships set up in your User model to retrieve the required information
        $universityId = $user->university_id;
        $departmentId = $user->department_id;
        $schoolLevelId = $user->school_level_id;
        $levelSemesterId = $user->level_semester_id;

        // Search for courses based on the user's parameters
        $courses = Course::where('university_id', $universityId)
                        ->where('department_id', $departmentId)
                        ->where('school_level_id', $schoolLevelId)
                        ->where('level_semester_id', $levelSemesterId)
                        ->get();

        // You can customize this response based on your application needs
        return response()->json([
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
