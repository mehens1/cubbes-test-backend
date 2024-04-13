<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidFaculty implements Rule
{
    private $universityId;

    public function __construct($universityId)
    {
        $this->universityId = $universityId;
    }

    public function passes($attribute, $value)
    {
        // Check if the faculty exists and belongs to the specified university
        $faculty = DB::table('faculties')
            ->where('id', $value)
            ->where('university_id', $this->universityId)
            ->exists();

        return $faculty;
    }

    public function message()
    {
        return 'The selected faculty is invalid or does not belong to the specified university.';
    }
}
