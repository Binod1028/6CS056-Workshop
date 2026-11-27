<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
</head>
<body>
    <h1>Courses</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('courses.create') }}">Create Course</a> | <a href="{{ route('students.index') }}">Students</a></p>

    <table border="1" cellpadding="8">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Code</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->code }}</td>
                    <td>
                        <a href="{{ route('courses.show', $course->id) }}">View</a>
                        <a href="{{ route('courses.edit', $course->id) }}">Edit</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No courses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
