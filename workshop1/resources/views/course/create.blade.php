<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
</head>
<body>
    <h1>Create Course</h1>

    @if ($errors->any())
        <div>
            <h2>Please fix the following errors:</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Course Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="code">Course Code</label>
            <input id="code" name="code" type="text" value="{{ old('code') }}" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit">Create Course</button>
    </form>

    <p><a href="{{ route('courses.index') }}">Back to Courses</a></p>
</body>
</html>
