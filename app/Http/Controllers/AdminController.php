<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\updateuserrequest;
use App\Models\Task;
use App\Http\Services\TaskService;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    protected $taskService;
    protected $adminService;

    public function __construct(TaskService $taskService, AdminService $adminService)
    {
        $this->taskService = $taskService;
        $this->adminService = $adminService;
    }

    public function indexTask()
    {
        $tasks = $this->taskService->index();
        return response()->json([
            'message' => 'Task list retrieved successfully',
            'tasks' => $tasks
        ], 200);
    }

    public function createTask(CreateTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return response()->json(['task' => $task], 201);
    }

    public function updateTask(UpdateTaskRequest $request, $id)
    {
        // Log or dump the validated data    
        // Find the task
        $task = Task::findOrFail($id);
        
        // Pass the validated data to the service for update
        $task = $this->taskService->updateTask($task, $request->validated());
    
        return response()->json(['task' => $task], 200);
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

    public function index()
    {
        $users = $this->adminService->index();
        return response()->json(['users' => $users], 200);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->adminService->store($request);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'user' => $user,
            'message' => 'User retrieved successfully'
        ], 200);
    }

    public function update(updateuserrequest $request, $id)
    {
        $user = $this->adminService->update($request,$id);
        return response()->json([
            'user' => $user,
            'message' => 'User updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->adminService->delete($id);
        return response()->json(['message' => 'User deleted successfully'], 204);
    }
}
