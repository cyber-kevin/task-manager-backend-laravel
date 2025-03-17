<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        if ($status != '' && !in_array($status, Task::$status)) {
            return response()->json(['message'=>'Invalid status.']);
        }

        $tasks = Task::where('user_id', $request->user()->id)
        ->when($status, fn($query, $status)=>$query->where('status', $status))
        ->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'status'=>'required|in:todo,doing,done,pending',
            'end_date'=>'required|date',
        ]);

        $task = Task::create([...$data, 'user_id'=>$request->user()->id]);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'status'=>'required|in:todo,doing,done,pending',
            'end_date'=>'required|date',
        ]);

        $task->update($data);

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
