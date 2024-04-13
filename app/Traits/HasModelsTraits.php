<?php

namespace App\Traits;

use App\Models\University;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use App\Models\SchoolLevel;
use App\Models\LevelSemester;

trait HasModelsTraits
{
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function level_semester()
    {
        return $this->belongsTo(LevelSemester::class, 'level_semester_id');
    }

    public function school_level()
    {
        return $this->belongsTo(SchoolLevel::class, 'school_level_id');
    }
}