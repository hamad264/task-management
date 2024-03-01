<?php

namespace App\Http\Controllers;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{


public function index()
{
    $tasks = Task::paginate(3);
    return view('tasks.index', ['tasks' => $tasks]);
}


public function store(TaskRequest $request)
    {

            $validatedData = $request->validated();

            $task = Task::create($validatedData);



if ($task) {
    Log::info('Task created successfully:', ['task' => $task]);
    return response()->json(['success' => true, 'task' => $task, 'message' => 'Task created successfully']);
} else {
    Log::error('Error creating task');
    return response()->json(['success' => false, 'error' => 'Error creating task']);
}
    }


    public function updatePriority(Request $request, $taskId)
    {
        try {
            $request->validate([
                'priority' => 'required|integer',
            ]);

            $task = Task::find($taskId);

            if (!$task) {
                return response()->json(['success' => false, 'error' => 'Task not found']);
            }

            $task->priority = $request->priority;
            $task->save();

            Log::info('Task priority updated successfully:', ['task' => $task]);

            return response()->json(['success' => true, 'task' => $task]);
        } catch (\Exception $e) {
            Log::error('Error updating task priority:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Error updating task priority']);
        }
    }

    public function sortByPriority()
    {
        $tasks = Task::orderBy('priority', 'desc')->get();
        return response()->json(['tasks' => $tasks]);
    }


}
