<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruClassroomTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_create_a_class_and_use_it_in_materials(): void
    {
        $teacher = User::factory()->create(['role' => 'guru']);

        $this->actingAs($teacher)
            ->get(route('guru.kelas.create'))
            ->assertOk();

        $this->actingAs($teacher)
            ->post(route('guru.kelas.store'), [
                'name' => 'Kelas 3B',
                'room' => 'Ruang 3B',
                'description' => 'Kelas uji',
            ])
            ->assertRedirect(route('guru.kelas.index'));

        $this->assertDatabaseHas('classrooms', [
            'teacher_id' => $teacher->id,
            'name' => 'Kelas 3B',
        ]);

        $this->get(route('guru.dashboard'))
            ->assertOk()
            ->assertSee('Kelas 3B');

        $this->get(route('guru.kelas.index'))
            ->assertOk()
            ->assertSee('Kelas 3B');

        $this->get(route('guru.materi'))
            ->assertOk()
            ->assertSee('Kelas 3B');

        $this->get(route('guru.video'))
            ->assertOk()
            ->assertSee('Kelas 3B');
    }

    public function test_teacher_cannot_edit_another_teachers_class(): void
    {
        $owner = User::factory()->create(['role' => 'guru']);
        $otherTeacher = User::factory()->create(['role' => 'guru']);
        $classroom = Classroom::create([
            'teacher_id' => $owner->id,
            'name' => 'Kelas 2A',
        ]);

        $this->actingAs($otherTeacher)
            ->get(route('guru.kelas.edit', $classroom))
            ->assertNotFound();
    }

    public function test_class_with_students_cannot_be_deleted(): void
    {
        $teacher = User::factory()->create(['role' => 'guru']);
        $classroom = Classroom::create([
            'teacher_id' => $teacher->id,
            'name' => 'Kelas 1A',
        ]);
        Student::create([
            'class_name' => $classroom->name,
            'nisn' => '1234567890',
            'name' => 'Siswa Uji',
            'gender' => 'L',
        ]);

        $this->actingAs($teacher)
            ->delete(route('guru.kelas.destroy', $classroom))
            ->assertRedirect();

        $this->assertDatabaseHas('classrooms', ['id' => $classroom->id]);
    }
}
