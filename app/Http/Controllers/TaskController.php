<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        
        $tasks = Task::latest()->paginate(5);

        return view('tasks.index', compact('tasks'));
       }

    public function create() {
        return view('tasks.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Task::create($request->only('title', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully!');
    }

    public function edit(Task $task) {
        return view('tasks.edit', compact('task'));
    }
    public function update(Request $request, Task $task)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
    
        // Update the task
        $task->update([
            'title' => $request->title,           
            'description' => $request->description, 
            'is_completed' => $request->has('is_completed') ? 1 : 0, 
        ]);
    
        // Redirect back to task list with success message
        return redirect()->route('tasks.index')->with('success', 'Task successfully updated!');
    }
    
    public function destroy(Task $task){
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task Successfully Deleted!');
    }
}
