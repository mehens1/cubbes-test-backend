<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasModelsTraits;

class TimeTable extends Model
{
    use HasFactory, HasModelsTraits;

    protected $fillable = [
        'course_id',
        'venue',
        'day_of_week',
        'start_time',
        'end_time',
        'user_id'
    ];
}
