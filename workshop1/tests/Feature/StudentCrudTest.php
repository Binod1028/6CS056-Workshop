<?php

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('student management', function () {
    it('shows students in the list', function () {
        Student::create([
            'name' => '<script>alert(1)</script>',
            'email' => 'student@example.com',
            'phone' => '555-1234',
        ]);

        $response = $this->get('/students');

        $response->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    });

    it('shows student details and the edit form', function () {
        $student = Student::create([
            'name' => 'Alex Student',
            'email' => 'alex@example.com',
            'phone' => '555-1234',
            'address' => '10 Main Street',
            'date_of_birth' => '2000-01-15',
        ]);

        $this->get("/students/{$student->id}")
            ->assertOk()
            ->assertSee('10 Main Street')
            ->assertSee('2000-01-15');

        $this->get("/students/{$student->id}/edit")
            ->assertOk()
            ->assertSee('value="alex@example.com"', false);
    });

    it('creates a student from valid form data', function () {
        $response = $this->post('/students', [
            'name' => 'Alex Student',
            'email' => 'alex@example.com',
            'phone' => '555-1234',
            'address' => '10 Main Street',
            'date_of_birth' => '2000-01-15',
        ]);

        $response->assertRedirect(route('students.index'))
            ->assertSessionHas('success', 'Student Alex Student created successfully!');

        $this->assertDatabaseHas('students', [
            'name' => 'Alex Student',
            'email' => 'alex@example.com',
            'address' => '10 Main Street',
            'date_of_birth' => '2000-01-15',
        ]);
    });

    it('returns to the form with an error when the name is missing', function () {
        $response = $this->from('/students/create')->post('/students', [
            'email' => 'alex@example.com',
            'phone' => '555-1234',
        ]);

        $response->assertRedirect('/students/create')
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

        $this->assertDatabaseCount('students', 0);
    });

    it('updates a student without rejecting the existing email', function () {
        $student = Student::create([
            'name' => 'Alex Student',
            'email' => 'alex@example.com',
            'phone' => '555-1234',
        ]);

        $response = $this->put("/students/{$student->id}", [
            'name' => 'Alex Updated',
            'email' => 'alex@example.com',
            'phone' => '555-5678',
            'address' => null,
            'date_of_birth' => null,
        ]);

        $response->assertRedirect(route('students.show', $student))
            ->assertSessionHas('success', 'Student updated successfully!');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Alex Updated',
            'email' => 'alex@example.com',
            'phone' => '555-5678',
        ]);
    });

    it('deletes a student', function () {
        $student = Student::create([
            'name' => 'Alex Student',
            'email' => 'alex@example.com',
            'phone' => '555-1234',
        ]);

        $response = $this->delete("/students/{$student->id}");

        $response->assertRedirect(route('students.index'))
            ->assertSessionHas('success', 'Student deleted successfully!');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    });

    it('returns 404 when a student does not exist', function () {
        $this->get('/students/999')->assertNotFound();
    });
});
