<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', function () {
    return view('student.list', ['students' => Student::all()]);
})->name('students.index');

Route::get('/students/create', function () {
    return view('student.create');
})->name('students.create');

Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:students,email'],
        'phone' => ['required', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:500'],
        'date_of_birth' => ['nullable', 'date'],
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
})->name('students.store');

Route::get('/students/{id}', function (string $id) {
    return view('student.detail', ['student' => Student::findOrFail($id)]);
})->name('students.show');

Route::get('/students/{id}/edit', function (string $id) {
    return view('student.edit', ['student' => Student::findOrFail($id)]);
})->name('students.edit');

Route::put('/students/{id}', function (Request $request, string $id) {
    $student = Student::findOrFail($id);
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
        'phone' => ['required', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:500'],
        'date_of_birth' => ['nullable', 'date'],
    ]);

    $student->update($validated);

    return redirect()->route('students.show', $student)
        ->with('success', 'Student updated successfully!');
})->name('students.update');

Route::delete('/students/{id}', function (string $id) {
    Student::findOrFail($id)->delete();

    return redirect()->route('students.index')
        ->with('success', 'Student deleted successfully!');
})->name('students.destroy');

Route::get('/courses', function () {
    return view('course.list', ['courses' => Course::all()]);
})->name('courses.index');

Route::get('/courses/create', function () {
    return view('course.create');
})->name('courses.create');

Route::post('/courses', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'code' => ['required', 'string', 'max:20', 'unique:courses,code'],
        'description' => ['nullable', 'string', 'max:1000'],
    ]);

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
})->name('courses.store');

Route::get('/courses/{id}', function (string $id) {
    return view('course.detail', ['course' => Course::findOrFail($id)]);
})->name('courses.show');

Route::get('/courses/{id}/edit', function (string $id) {
    return view('course.edit', ['course' => Course::findOrFail($id)]);
})->name('courses.edit');

Route::put('/courses/{id}', function (Request $request, string $id) {
    $course = Course::findOrFail($id);
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course->id)],
        'description' => ['nullable', 'string', 'max:1000'],
    ]);

    $course->update($validated);

    return redirect()->route('courses.show', $course)
        ->with('success', 'Course updated successfully!');
})->name('courses.update');

Route::delete('/courses/{id}', function (string $id) {
    Course::findOrFail($id)->delete();

    return redirect()->route('courses.index')
        ->with('success', 'Course deleted successfully!');
})->name('courses.destroy');
