<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>

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

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required>
        </div>
        <div>
            <label for="phone">Phone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $student->phone) }}" required>
        </div>
        <div>
            <label for="address">Address</label>
            <textarea id="address" name="address">{{ old('address', $student->address) }}</textarea>
        </div>
        <div>
            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student->date_of_birth) }}">
        </div>
        <button type="submit">Update Student</button>
    </form>

    <p><a href="{{ route('students.index') }}">Back to Students</a></p>
</body>
</html>
