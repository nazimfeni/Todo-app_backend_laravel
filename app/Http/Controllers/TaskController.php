<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        
        return response()->json(Task::all());
    }

    public function store(Request $request)
    {
        // dd("ok");
        // dd($request->all());
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'task' => $request->task,
            'completed' => false,
        ]);

        return response()->json($task);
    }

    public function markAsCompleted($id)
{
   
    $task = Task::findOrFail($id);
    $task->completed = !$task->completed; // Toggle completion status
    $task->save();

    return response()->json($task);
}


public function destroy($id)
{
    $task = Task::findOrFail($id);
    $task->delete();

    return response()->json(['message' => 'Task deleted successfully.']);
}

}
