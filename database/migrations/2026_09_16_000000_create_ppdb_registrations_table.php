<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('student_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('gender', 1);
            $table->string('nik', 16)->nullable();
            $table->string('kk_number', 16)->nullable();
            $table->string('parent_name');
            $table->string('phone', 25);
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('previous_school')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
