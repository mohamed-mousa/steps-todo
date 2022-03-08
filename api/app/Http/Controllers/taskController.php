<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class taskController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function projects_task_count()
    {
        $tasks = Task::count();
        $projects = Project::count();
        return response()->json([$projects, $tasks]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'task_name' => 'required|string|min:3',
        ]);

        $task =  Task::create([
            'task_name'  => request('task_name'),
            'project_id' => request('project_id'),
            'user_id'    => auth()->user()->id,
            'waiting'    => 1,
            'completed'    => 0,
            'rejected'    => 0,
            'inprogress'    => 0,
        ]);

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->validate($request, [
            'task_name' => 'required|string|min:3',
        ]);

        $task->task_name = $request->task_name;

        if ($task->user_id == auth()->user()->id) {
            $task->save();
            return response()->json([$task]);
        } else {
            return response()->json(['message' => 'Unauthorized']);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::where('id', $id)->delete();
        return response()->json(['message' => 'delete']);
    }

    // waiting
    public function waiting($id)
    {
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);
        $tasks = $project->tasks;
        $task->waiting = true;
        $task->completed = false;
        $task->rejected = false;
        $task->inprogress = false;
        $task->save();
        return response()->json([$task]);
    }

    // completed
    public function completed($id)
    {
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);
        $tasks = $project->tasks;
        $task->waiting = false;
        $task->completed = true;
        $task->rejected = false;
        $task->inprogress = false;
        $task->save();
        return response()->json([$task]);
    }

    // rejected
    public function rejected($id)
    {
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);
        $tasks = $project->tasks;
        $task->waiting = false;
        $task->completed = false;
        $task->rejected = true;
        $task->inprogress = false;
        $task->save();
        return response()->json([$task]);
    }

    // inprogress
    public function inprogress($id)
    {
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);
        $tasks = $project->tasks;
        $task->waiting = false;
        $task->completed = false;
        $task->rejected = false;
        $task->inprogress = true;
        $task->save();
        return response()->json([$task]);
    }
}
