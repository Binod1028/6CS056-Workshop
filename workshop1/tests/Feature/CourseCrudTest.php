<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('course management', function () {
    it('shows courses in the list', function () {
        Course::create([
            'name' => 'Web Development',
            'code' => 'WEB101',
            'description' => 'Learn to build web applications.',
        ]);

        $response = $this->get('/courses');

        $response->assertOk()
            ->assertSee('Web Development')
            ->assertSee('WEB101');
    });

    it('shows course details and the edit form', function () {
        $course = Course::create([
            'name' => 'Web Development',
            'code' => 'WEB101',
            'description' => 'Learn to build web applications.',
        ]);

        $this->get("/courses/{$course->id}")
            ->assertOk()
            ->assertSee('Learn to build web applications.');

        $this->get("/courses/{$course->id}/edit")
            ->assertOk()
            ->assertSee('value="WEB101"', false);
    });

    it('creates a course from valid form data', function () {
        $response = $this->post('/courses', [
            'name' => 'Web Development',
            'code' => 'WEB101',
            'description' => 'Learn to build web applications.',
        ]);

        $response->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Course Web Development created successfully!');

        $this->assertDatabaseHas('courses', [
            'name' => 'Web Development',
            'code' => 'WEB101',
            'description' => 'Learn to build web applications.',
        ]);
    });

    it('returns to the form with an error when the course code is missing', function () {
        $response = $this->from('/courses/create')->post('/courses', [
            'name' => 'Web Development',
        ]);

        $response->assertRedirect('/courses/create')
            ->assertSessionHasErrors(['code' => 'The code field is required.']);

        $this->assertDatabaseCount('courses', 0);
    });

    it('updates a course without rejecting the existing code', function () {
        $course = Course::create([
            'name' => 'Web Development',
            'code' => 'WEB101',
            'description' => 'Introductory course.',
        ]);

        $response = $this->put("/courses/{$course->id}", [
            'name' => 'Advanced Web Development',
            'code' => 'WEB101',
            'description' => 'Advanced course.',
        ]);

        $response->assertRedirect(route('courses.show', $course))
            ->assertSessionHas('success', 'Course updated successfully!');

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced Web Development',
            'code' => 'WEB101',
            'description' => 'Advanced course.',
        ]);
    });

    it('deletes a course', function () {
        $course = Course::create([
            'name' => 'Web Development',
            'code' => 'WEB101',
        ]);

        $response = $this->delete("/courses/{$course->id}");

        $response->assertRedirect(route('courses.index'))
            ->assertSessionHas('success', 'Course deleted successfully!');

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    });

    it('returns 404 when a course does not exist', function () {
        $this->get('/courses/999')->assertNotFound();
    });
});
