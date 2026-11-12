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
        Schema::table('educational_videos', function (Blueprint $table) {
            $table->string('source_type')->default('youtube')->after('description'); // 'youtube' or 'google_drive'
            $table->text('video_url')->nullable()->after('source_type');
            $table->string('youtube_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educational_videos', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'video_url']);
            $table->string('youtube_url')->nullable(false)->change();
        });
    }
};
