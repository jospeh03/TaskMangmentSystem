<?php
namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function index(){
        $Tasks = Task::with(['book', 'user'])->get();
        return $Tasks;
    }
    public function createTask(array $data)
    {
        $data['assigned_by'] = Auth::id();
        return Task::create($data);
    }

    public function updateTask(Task $task, array $data)
    {
        // Update the task with the new data
        $task->update($data);
        return $task; // Return the updated task
    }
        public function assignTask(Task $task, $assigned_to)
    {
        $task->assigned_to = $assigned_to;
        $task->save();
        return $task;
    }

    public function updateTaskStatus(Task $task, $status)
    {
        if ($task->assigned_to == Auth::id()) {
            $task->status = $status;
            $task->save();
            return $task;
        }
        return response()->json(['error' => 'You are not assigned to this task'], 403);
    }
    public function scopePriority($query, $priority) {
        return $query->where('priority', $priority);
    }

    public function scopeStatus($query, $status) {
        return $query->where('status', $status);
    }
}
