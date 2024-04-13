<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->unique()->nullable();
            $table->tinyInteger('account_type')->default(0);
            $table->foreignId('university_id')->nullable()->constrained('universities');
            $table->foreignId('faculty_id')->nullable()->constrained('faculties');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('school_level_id')->nullable()->constrained('school_levels');
            $table->foreignId('level_semester_id')->nullable()->constrained('level_semesters');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
