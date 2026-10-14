<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id')->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('activity_type')->index(); // registration_created, status_changed, file_uploaded, etc
            $table->string('description');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('registration_id')->references('id')->on('ppdb_registrations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_activities');
    }
};
