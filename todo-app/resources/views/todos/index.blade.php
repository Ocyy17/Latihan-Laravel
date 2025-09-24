<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url("{{ asset('images/background.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .page-wrap {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            width: 80%;
            max-width: 1000px;
        }

        table {
            border-radius: 10px;
            overflow: hidden;
            /* Transparansi tabel */
            background-color: rgba(255, 255, 255, 0.5);
        }

        table thead {
            background: rgba(255, 255, 255, 0.7);
        }

        .table tbody tr {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .animate__animated.animate__pulse {
            --animate-duration: 2s;
            --animate-delay: 0.5s;
            animation-iteration-count: infinite;
        }
    </style>
</head>

<body>
    <div class="page-wrap animate__animated animate__fadeIn">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold">📋 Daftar Tugas</h1>
            <div id="clock" class="fw-bold text-primary"></div>
        </div>

        <form id="delete-multiple-form" action="{{ route('todos.deleteMultiple') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="{{ route('todos.create') }}" class="btn btn-success animate__animated animate__pulse">➕ Buat Tugas Baru</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-danger" id="delete-multiple-btn" style="display: none;">
                        🗑️ Hapus Tugas Terpilih
                    </button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all"></th>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Update Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todos as $index => $todo)
                <tr id="todo-{{ $todo->id }}" class="animate__animated animate__fadeIn">
                    <td><input type="checkbox" name="ids[]" value="{{ $todo->id }}" class="todo-checkbox"></td>
                    <td>{{ $index+1 }}</td>
                    <td><strong>{{ $todo->title }}</strong></td>
                    <td>{{ $todo->description }}</td>
                    <td>
                        <span class="badge {{ $todo->is_done ? 'bg-success' : 'bg-danger' }}">
                            {{ $todo->is_done ? 'Selesai' : 'Belum selesai' }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($todo->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($todo->updated_at)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if(!$todo->is_done)
                        <form action="{{ route('todos.done', $todo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success">✅ Selesai</button>
                        </form>
                        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-primary">✏️ Edit</a>
                        @else
                        <form action="{{ route('todos.undo', $todo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-warning">💡 EH BELUM SELESAI</button>
                        </form>
                        <button class="btn btn-sm btn-secondary" disabled>✏️ Edit (Selesai)</button>
                        @endif
                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada tugas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Flash message SweetAlert --}}
    @if(session('success_add'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success_add') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('success_edit'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Tugas Diedit!',
            text: "{{ session('success_edit') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('success_done'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Selesai!',
            text: "{{ session('success_done') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('success_undo'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Undo!',
            text: "{{ session('success_undo') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ session('error') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Skrip untuk hapus massal
            const checkAll = document.getElementById('check-all');
            const checkboxes = document.querySelectorAll('.todo-checkbox');
            const deleteMultipleBtn = document.getElementById('delete-multiple-btn');
            const deleteMultipleForm = document.getElementById('delete-multiple-form');

            function updateDeleteButtonVisibility() {
                const checkedCount = document.querySelectorAll('.todo-checkbox:checked').length;
                if (checkedCount > 0) {
                    deleteMultipleBtn.style.display = 'block';
                } else {
                    deleteMultipleBtn.style.display = 'none';
                }
            }

            checkAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateDeleteButtonVisibility();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButtonVisibility);
            });

            // SweetAlert for mass delete confirmation
            deleteMultipleForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const selectedIds = Array.from(document.querySelectorAll('.todo-checkbox:checked')).map(cb => cb.value);

                // Jika tidak ada ID yang dipilih, tampilkan pesan error
                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Tidak ada tugas yang dipilih!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    title: 'Yakin mau hapus tugas yang dipilih?',
                    text: "Tugas ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Hapus input hidden yang mungkin sudah ada
                        const oldInputs = deleteMultipleForm.querySelectorAll('input[name="ids[]"]');
                        oldInputs.forEach(input => input.remove());

                        // Buat input hidden baru untuk setiap ID yang dipilih
                        selectedIds.forEach(id => {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'ids[]';
                            hiddenInput.value = id;
                            deleteMultipleForm.appendChild(hiddenInput);
                        });

                        // Kirim form setelah input hidden ditambahkan
                        e.target.submit();
                    }
                });
            });


            // SweetAlert untuk hapus satu per satu
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    let form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin mau hapus?',
                        text: "Tugas ini tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let row = form.closest("tr");
                            row.classList.add("animate__animated", "animate__fadeOut");
                            setTimeout(() => form.submit(), 500);
                        }
                    });
                });
            });
        });

        // Script untuk jam
        function updateClock() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const clockElement = document.getElementById('clock');
            if (clockElement) {
                clockElement.innerText = now.toLocaleDateString('id-ID', options);
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>