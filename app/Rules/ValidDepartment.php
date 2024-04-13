<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidDepartment implements Rule
{
    private $facultyId;

    public function __construct($facultyId)
    {
        $this->facultyId = $facultyId;
    }

    public function passes($attribute, $value)
    {
        // Check if the department exists and belongs to the specified faculty
        $department = DB::table('departments')
            ->where('id', $value)
            ->where('faculty_id', $this->facultyId)
            ->exists();

        return $department;
    }

    public function message()
    {
        return 'The selected department is invalid or does not belong to the specified faculty.';
    }
}
