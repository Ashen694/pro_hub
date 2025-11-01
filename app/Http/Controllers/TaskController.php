<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Freelancer;

class TaskController extends Controller
{

        public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name'=>'required',
            'specification'=>'required',
            'payment'=>'required|numeric',
            'delivery_due_date'=>'required|date',
            'status'=>'required',
            'paid' => 'required|boolean'


        ]);

        // Optional: check if payment <= freelancer total amount
        if($request->payment > $task->freelancer->total_amount){
            return back()->with('error', 'Payment cannot exceed freelancer total amount!');
        }

        $task->update($request->only(['task_name','specification','payment','delivery_due_date','status','paid']));

         
        return redirect()->route('freelancers.create')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success','Task deleted successfully!');
    }

}
