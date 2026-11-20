<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WorkshopTwoTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_crud_and_shared_layout_work(): void
    {
        $response = $this->get(route('students.index'));

        $response->assertOk()
            ->assertSee('Training Institute')
            ->assertSee('Students')
            ->assertSee('Courses')
            ->assertSee('Training Institute Management System');

        $student = Student::create([
            'name' => 'Workshop Student',
            'email' => Str::uuid().'@example.test',
            'phone' => '0123456789',
            'address' => 'Workshop address',
            'date_of_birth' => '2000-01-01',
        ]);

        $this->get(route('students.show', $student))->assertOk()->assertSee($student->name);
        $this->get(route('students.edit', $student))->assertOk()->assertSee('Date of Birth');

        $this->put(route('students.update', $student), [
            'name' => 'Updated Student',
            'email' => $student->email,
            'phone' => $student->phone,
            'address' => $student->address,
            'date_of_birth' => '2000-01-01',
        ])->assertRedirect(route('students.show', $student));

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_course_crud_and_validation_work(): void
    {
        $this->from(route('courses.create'))
            ->post(route('courses.store'), [])
            ->assertRedirect(route('courses.create'))
            ->assertSessionHasErrors(['name', 'duration', 'fee', 'difficulty']);

        $this->post(route('courses.store'), [
            'name' => 'Laravel Workshop',
            'description' => 'Course description',
            'duration' => 6,
            'fee' => 125.50,
            'difficulty' => 'Medium',
            'is_active' => 1,
        ])->assertRedirect(route('courses.index'));

        $course = Course::query()->where('name', 'Laravel Workshop')->latest('id')->firstOrFail();

        $this->get(route('courses.show', $course))->assertOk()->assertSee($course->name);
        $this->get(route('courses.edit', $course))->assertOk()->assertSee('Difficulty');

        $this->put(route('courses.update', $course), [
            'name' => 'Updated Laravel Workshop',
            'description' => $course->description,
            'duration' => 8,
            'fee' => 150,
            'difficulty' => 'Hard',
            'is_active' => 1,
        ])->assertRedirect(route('courses.show', $course));

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
