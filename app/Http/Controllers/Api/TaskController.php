<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    public function list(Request $request)
    {
        $query = Auth::user()->tasks(); 

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(5);

        return response()->json($tasks);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,completed,in-progress'
        ]);

        $task = Auth::user()->tasks()->create($data);

        return response()->json([
            'message' => 'Task created',
            'task' => $task
        ], 201);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,completed,in-progress'
        ]);

        $task->update($data);

        return response()->json([
            'message' => 'Task updated',
            'task' => $task
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'status' => 'required|string|in:pending,completed,in-progress'
        ]);

        $task->update(['status' => $data['status']]);

        return response()->json([
            'message' => 'Status updated',
            'task' => $task
        ]);
    }

    public function delete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($task);
    }
}
