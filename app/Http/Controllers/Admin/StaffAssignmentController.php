<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookService;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class StaffAssignmentController extends Controller
{
    /**
     * Display a listing of bookings with tasks for staff assignment.
     */
    public function index(Request $request)
    {
        // Get all staff members
        $staff = User::where('accountType', 'staff')
                    
                     ->orWhere('accountType', 'driver')
                     ->orWhere('accountType', 'embalmer')
                     ->orderBy('name')
                     ->get();

        // Start query for bookings with relationships
        $query = BookService::with([
            'deceased',
            'client',
            'package',
            'tasks.staff'
        ]);

        // Filter by booking status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by task type
        if ($request->filled('task_type')) {
            $query->whereHas('tasks', function ($q) use ($request) {
                $q->where('task_type', $request->task_type);
            });
        }

        // Filter by task status
        if ($request->filled('task_status')) {
            $query->whereHas('tasks', function ($q) use ($request) {
                $q->where('status', $request->task_status);
            });
        }

        // Exclude released/declined bookings unless specifically filtered
        if (!$request->filled('status')) {
            $query->whereNotIn('status', ['Released', 'Declined']);
        }

        // Order by most recent first
        $bookings = $query->orderBy('created_at', 'desc')
                          ->paginate(5)
                          ->appends($request->query());

        return view('admin.assignment.assignment-index', compact('bookings', 'staff'));
    }


    public function createTask(Request $request, $booking)
{
    $validated = $request->validate([
        'task_type' => 'required|in:Retrieval,Embalming,Dressing,Viewing',
        'staff_id' => 'nullable|exists:users,id',
        'notes' => 'nullable|string|max:500',
    ]);

    // Find booking by ID
    $bookingModel = BookService::findOrFail($booking);

    // Check if booking status is Pending
    if ($bookingModel->status === 'Pending') {
        return redirect()->back()
                         ->with('error', 'Cannot create tasks for bookings that are still pending.');
    }

    // Check if this task type already exists for this booking
    $existingTask = $bookingModel->tasks()
                                ->where('task_type', $validated['task_type'])
                                ->first();

    if ($existingTask) {
        return redirect()->back()
                         ->with('error', 'A task of this type already exists for this booking.');
    }

    // Create the task
    $task = new Task([
        'book_service_id' => $bookingModel->id,
        'task_type' => $validated['task_type'],
        'staff_id' => $validated['staff_id'] ?? null,
        'status' => 'Pending',
        'notes' => $validated['notes'] ?? null,
    ]);

    $task->save();

    return redirect()->back()
                     ->with('success', 'Task created successfully!');
}


    /**
     * Assign staff to a task and update its status.
     */
    public function assignTask(Request $request, $task)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'status' => 'required|in:Pending,In Progress,Completed',
            'notes' => 'nullable|string|max:500',
        ]);

        // Find task by ID
        $taskModel = Task::findOrFail($task);

        $taskModel->update([
            'staff_id' => $validated['staff_id'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $taskModel->notes,
        ]);

        $staffName = $taskModel->staff->name;

    

        return redirect()->back()
                       ->with('success', "Task assigned to {$staffName} successfully!");
    }

    /**
     * Delete a task.
     */
    public function deleteTask($task)
    {
        $taskModel = Task::findOrFail($task);
        $taskModel->delete();

        return redirect()->back()
                       ->with('success', 'Task deleted successfully!');
    }

    /**
     * Update only the task status (quick update).
     */
    public function updateTaskStatus(Request $request, $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $taskModel = Task::findOrFail($task);
        $taskModel->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully!',
        ]);
    }

    /**
     * Get staff workload (optional - for analytics).
     */
    public function staffWorkload()
    {
        $staff = User::where('accountType', 'staff')
             ->orWhere('accountType', 'admin')
             ->orWhere('accountType', 'embalmer')
             ->orWhere('accountType', 'driver')
                    ->withCount([
                        'tasks as pending_tasks' => function ($q) {
                            $q->where('status', 'Pending');
                        },
                        'tasks as in_progress_tasks' => function ($q) {
                            $q->where('status', 'In Progress');
                        },
                        'tasks as completed_tasks' => function ($q) {
                            $q->where('status', 'Completed');
                        }
                    ])
                    ->get();

        return view('admin.assignment.workload', compact('staff'));
    }
}