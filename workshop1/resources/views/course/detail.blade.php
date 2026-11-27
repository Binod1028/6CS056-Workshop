<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
</head>
<body>
    <h1>Course Details</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p><strong>ID:</strong> {{ $course->id }}</p>
    <p><strong>Name:</strong> {{ $course->name }}</p>
    <p><strong>Code:</strong> {{ $course->code }}</p>
    <p><strong>Description:</strong> {{ $course->description }}</p>

    <p><a href="{{ route('courses.edit', $course->id) }}">Edit Course</a></p>
    <p><a href="{{ route('courses.index') }}">Back to Courses</a></p>
</body>
</html>
