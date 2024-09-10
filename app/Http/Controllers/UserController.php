<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Remove unnecessary middleware here since it's already in the route
    
    public function updateTaskStatus(Request $request, $id)
    {
        // Validate the incoming status
        $request->validate([
            'status' => 'required|string|in:pending,completed,in-progress', // Adjust statuses as needed
        ]);

        // Fetch the task assigned to the authenticated user
        $task = Task::where('assigned_to', auth()->id())->findOrFail($id);

        // Update the task's status
        $task->update(['status' => $request->status]);

        // Return a success response
        return response()->json(['task' => $task], 200);
    }
}
