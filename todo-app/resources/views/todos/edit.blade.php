<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url("{{ asset('images/background.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="container py-5">

    <h1 class="mb-4 text-primary fw-bold">✏️ Edit Tugas</h1>

    {{-- tampilkan error validasi --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Tugas</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $todo->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Keterangan</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $todo->description) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_done" id="is_done" class="form-check-input"
                {{ $todo->is_done ? 'checked' : '' }}>
            <label for="is_done" class="form-check-label">Selesai?</label>
        </div>

        <button type="submit" class="btn btn-primary">💾 Update</button>
        <a href="{{ route('todos.index') }}" class="btn btn-secondary">↩ Kembali</a>
    </form>

</body>

</html>