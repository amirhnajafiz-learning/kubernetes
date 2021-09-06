<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index($id = -1)
    {
        $validate = \Illuminate\Support\Facades\Validator::make(['id' => $id], [
            'id' => 'exists:App\Models\Task,id'
        ])->validate();
        if($id == -1)
        {
            $id = Auth::id();
        }
        $tasks = Task::query()->where('user_id', '=', $id)->get();
        return view('components/task/task')
            ->with('tasks', $tasks)
            ->with('status', session('status'))
            ->with('title', 'task');
    }

    public function create()
    {
        $users = User::all();
        return view('components/task/task_create')
            ->with('users', $users)
            ->with('title', 'task - create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:64',
            'description' => 'required'
        ]);
        $task = Task::query()->create($request->all());
        return redirect()
            ->route('task.index')
            ->with('status', (bool)$task);
    }

    public function show($id)
    {
        $task = Task::query()->findOrFail($id);
        return view('components.task.task_show')
            ->with('task', $task)
            ->with('title', 'task - view');
    }

    public function toggleToDo($id)
    {
        $task = Task::query()->findOrFail($id);
        $value = $task->is_done == 1 ? 0 : 1;
        $task->update(['is_done' => $value]);
        return redirect()
            ->route('task.show', $id)
            ->with('message', 'Task updated');
    }

    public function delete($id)
    {
        Task::query()->find($id)->delete();
        return redirect()
            ->route('task.index', $id)
            ->with('message', 'Task deleted');
    }

    public function force($id)
    {
        Task::withTrashed()->find($id)->forceDelete();
        return redirect()
            ->route('task.index')
            ->with('message', 'Task deleted');
    }

    public function restore($id)
    {
        Task::withTrashed()->find($id)->restore();
        return redirect()
            ->route('task.show', $id);
    }

    public function trash($id)
    {
        $validate = \Illuminate\Support\Facades\Validator::make(['id' => $id], [
            'id' => 'exists:App\Models\User,id'
        ])->validate();
        $tasks = Task::onlyTrashed()->where('user_id', '=', $id)->get();
        return view('components.task.task_trash')
            ->with('tasks', $tasks)
            ->with('title', 'trash');
    }
}
