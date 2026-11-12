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
        // 1. Tabel Siswa
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('class_name'); // e.g. Kelas 4A, Kelas 5A, Kelas 6B
            $table->string('nisn')->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->timestamps();
        });

        // 2. Tabel Presensi Siswa
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('date');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa'])->default('Hadir');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'date']);
        });

        // 3. Tabel Materi Pembelajaran
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('subject');
            $table->string('class_level'); // e.g. Kelas IV, Kelas V, Kelas VI
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->default('PDF Dokumen');
            $table->string('file_size')->default('1.5 MB');
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });

        // 4. Tabel Video Edukasi
        Schema::create('educational_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('subject');
            $table->string('class_level');
            $table->text('description')->nullable();
            $table->string('youtube_url');
            $table->string('duration')->default('10:00');
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });

        // 5. Tabel Tugas & Penilaian
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('subject');
            $table->string('class_level');
            $table->string('deadline');
            $table->text('description')->nullable();
            $table->integer('total_students')->default(30);
            $table->integer('submitted_count')->default(0);
            $table->string('status')->default('Aktif'); // Aktif / Selesai
            $table->timestamps();
        });

        // 6. Tabel Nilai & Pengumpulan Siswa
        Schema::create('assignment_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('grade')->nullable();
            $table->string('feedback')->nullable();
            $table->string('status')->default('Terkumpul'); // Terkumpul / Dinilai
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_grades');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('educational_videos');
        Schema::dropIfExists('learning_materials');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('students');
    }
};
