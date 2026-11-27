<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
</head>
<body>
    <h1>Create Student</h1>

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

    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="phone">Phone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required>
        </div>
        <div>
            <label for="address">Address</label>
            <textarea id="address" name="address">{{ old('address') }}</textarea>
        </div>
        <div>
            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}">
        </div>
        <button type="submit">Create Student</button>
    </form>

    <p><a href="{{ route('students.index') }}">Back to Students</a></p>
</body>
</html>
