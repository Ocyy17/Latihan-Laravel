<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_done' => false,
        ]);

        return redirect()->route('todos.index')->with('success_add', 'Tugas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_done' => $request->has('is_done'),
        ]);

        return redirect()->route('todos.index')
            ->with('success_edit', 'Tugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function done($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = true;
        $todo->save();

        return redirect()->route('todos.index')->with('success_done', 'Tugas berhasil diselesaikan!');
    }

    public function undo($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = false;
        $todo->save();

        return redirect()->route('todos.index')->with('success_undo', 'Tugas dikembalikan ke status belum selesai!');
    }


    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Todo::whereIn('id', $ids)->delete();
            return redirect()->route('todos.index')->with('success', 'Beberapa tugas berhasil dihapus!');
        }
        return redirect()->route('todos.index')->with('error', 'Tidak ada tugas yang dipilih!');
    }
}
