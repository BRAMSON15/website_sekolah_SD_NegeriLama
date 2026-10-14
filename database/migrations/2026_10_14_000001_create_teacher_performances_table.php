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
        Schema::create('teacher_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->integer('materials_count')->default(0);
            $table->integer('videos_count')->default(0);
            $table->integer('assignments_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('activity_score')->default(0); // 0-100
            $table->enum('status', ['active', 'inactive', 'pending'])->default('inactive');
            $table->timestamps();
            
            // Index
            $table->index('status');
            $table->index('last_activity_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_performances');
    }
};
