<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Services\TaskService;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function assignTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task = $this->taskService->assignTask($task, $request->assigned_to);
        return response()->json(['task' => $task], 200);
    }
}
