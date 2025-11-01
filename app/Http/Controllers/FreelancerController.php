<?php

namespace App\Http\Controllers;
use App\Models\Freelancer;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;


class FreelancerController extends Controller
{

        public function create()
    {
        $freelancers = Freelancer::with('tasks')->latest()->get();
        return view('freelancers.create', compact('freelancers'));
    }

    // Show all freelancers
    public function index()
    {
        $freelancers = Freelancer::with('tasks')->latest()->get();
        return view('freelancers.all', compact('freelancers'));
    }

    // Store freelancer and tasks
    public function store(Request $request)
    {
        // Validate freelancer main details
        $request->validate([
            'name' => 'required|string',
            'nic' => 'required|string',
            'project_name' => 'required|string',
            'project_scope' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'budget_available' => 'required',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'tasks' => 'nullable'
        ]);

        $tasks = $request->tasks ?? [];
        if (is_string($tasks)) $tasks = json_decode($tasks, true);
        if (!is_array($tasks)) $tasks = [];

        // Calculate total payment for all tasks
        $totalTaskPayment = 0;
        foreach ($tasks as $task) {
            if (is_array($task)) {
                $totalTaskPayment += floatval($task['payment'] ?? 0);
            }
        }

        $totalAmount = floatval($request->total_amount);

        // If task total > project total => show error
        if ($totalTaskPayment > $totalAmount) {
            return back()->withInput()->with('error',
                'Tasks total payment (Rs. ' . number_format($totalTaskPayment, 2) .
                ') exceeds project total amount (Rs. ' . number_format($totalAmount, 2) . '). 
                Please adjust task payments or increase total amount.'
            );
        }

        //Use DB transaction to ensure data integrity
        DB::beginTransaction();
        try {
            // Save freelancer
            $freelancer = Freelancer::create($request->only([
                'name', 'nic', 'project_name', 'project_scope', 'total_amount',
                'budget_available', 'duration', 'start_date', 'end_date'
            ]));

            // Save each task
            foreach ($tasks as $task) {
                if (!is_array($task)) continue;

                $freelancer->tasks()->create([
                    'task_name' => $task['task_name'] ?? '',
                    'specification' => $task['specification'] ?? null,
                    'payment' => $task['payment'] ?? 0,
                    'delivery_due_date' => $task['delivery_due_date'] ?? now(),
                    'status' => $task['status'] ?? 'Open',
                    'paid' => $task['paid'] ?? false
                ]);
            }

            DB::commit();
            return redirect()->route('freelancers.create')
                ->with('success', 'Freelancer and tasks saved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Freelancer store failed: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error occurred while saving data.');
        }
    }

    // Edit task form
    public function editTask(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update task details
    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required|string',
            'specification' => 'nullable|string',
            'payment' => 'required|numeric|min:0',
            'delivery_due_date' => 'required|date',
            'status' => 'required|string',
            'paid' => 'required|boolean'


        ]);

        $freelancer = $task->freelancer;
        $totalAmount = $freelancer->total_amount;

        // Calculate new total if this task updated
        $otherTasksSum = $freelancer->tasks()->where('id', '!=', $task->id)->sum('payment');
        $newTotal = $otherTasksSum + floatval($request->payment);

        if ($newTotal > $totalAmount) {
            return back()->with('error',
                'Updated payment causes total task payments (Rs. ' . number_format($newTotal, 2) .
                ') to exceed project total (Rs. ' . number_format($totalAmount, 2) . ').'
            );
        }

        $task->update($request->only(['task_name','specification','payment','delivery_due_date','status']));
        return redirect()->route('freelancers.create')->with('success', 'Task updated successfully!');
    }

    // Delete a task
    public function deleteTask(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully!');
    }

    // Show all freelancers with tasks
    public function allFreelancers()
    {
        $freelancers = Freelancer::with('tasks')->latest()->get();
        return view('freelancers.all', compact('freelancers'));
    }  
    
    
public function edit($id)
{
    $freelancer = Freelancer::with('tasks')->findOrFail($id);
    return view('freelancers.edit', compact('freelancer'));
}

public function destroy(Freelancer $freelancer)
{
    $freelancer->delete();
    return redirect()->route('freelancers.all')->with('success', 'Freelancer deleted successfully!');
}

//---------------edit.blade method-----------
public function update(Request $request, $id)
    {
        $freelancer = Freelancer::findOrFail($id);

        // Validate freelancer fields
        $request->validate([
            'name' => 'required|string',
            'nic' => 'required|string',
            'project_name' => 'required|string',
            'project_scope' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'budget_available' => 'required|in:Yes,No',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'duration' => 'nullable|string',
        ]);

        // Update freelancer details
        $freelancer->update($request->only([
            'name', 'nic', 'project_name', 'project_scope', 
            'total_amount', 'budget_available', 'start_date', 'end_date', 'duration'
        ]));

        // Handle tasks
        $tasks = $request->input('tasks', []);
        
       
       
       
       
        // 1. Get IDs of all EXISTING tasks related to this freelancer
        $existingTaskDbIds = $freelancer->tasks->pluck('id')->toArray();

        // 2. Get the DB IDs of EXISTING tasks that were submitted back from the form
        $submittedOldTaskDbIds = [];
        foreach ($tasks as $key => $taskData) {
            // Check if the key starts with 'old_' (meaning it's an existing task being updated)
            if (str_starts_with($key, 'old_')) {
                // Extract the actual Database ID from the key (e.g., 'old_5' -> 5)
                $submittedOldTaskDbIds[] = (int) str_replace('old_', '', $key);
            }
        }
        
        // 3. Find which existing DB IDs are NOT in the submitted list (these are the deleted ones)
        $dbIdsToDelete = array_diff($existingTaskDbIds, $submittedOldTaskDbIds);
        
        // 4. Delete the found tasks from the database
        if (!empty($dbIdsToDelete)) {
            Task::whereIn('id', $dbIdsToDelete)->delete(); // Use Task model for deletion
        }
        // ---------------------------------------------

        foreach ($tasks as $key => $taskData) {

            // Status mapping logic
            $status = isset($taskData['status']) ? trim($taskData['status']) : 'Open';
            $status = strtolower($status);
            
            if ($status === 'open') $status = 'Open';
            elseif ($status === 'in progress') $status = 'In Progress';
            elseif ($status === 'completed') $status = 'Completed';
            else $status = 'Open';

            // Old task: update
            if (str_starts_with($key, 'old_')) {
                $taskId = (int) str_replace('old_', '', $key);
                $task = Task::find($taskId);
                if ($task) {
                    $task->update([
                        'task_name' => $taskData['task_name'] ?? '',
                        'specification' => $taskData['specification'] ?? null,
                        'payment' => $taskData['payment'] ?? 0,
                        'delivery_due_date' => $taskData['delivery_due_date'] ?? null,
                        'status' => $status, 
                        'paid' => $taskData['paid'] ?? 0,
                    ]);
                }
            } 
            // New task: create
            else {
                $freelancer->tasks()->create([
                    'task_name' => $taskData['task_name'] ?? '',
                    'specification' => $taskData['specification'] ?? null,
                    'payment' => $taskData['payment'] ?? 0,
                    'delivery_due_date' => $taskData['delivery_due_date'] ?? null,
                    'status' => $status, 
                    'paid' => $taskData['paid'] ?? 0,
                ]);
            }
        }

        

        return redirect()->route('freelancers.all') // Redirect to list or wherever suitable
                         ->with('success', 'Freelancer and tasks updated successfully!');
    }
}
