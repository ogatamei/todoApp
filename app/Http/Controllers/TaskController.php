<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function index(int $id)
    // public function index(Folder $folder)
    {
        // ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        // if(is_null($current_folder)){
        //     abort(404);
        // }

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();
        // $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function showCreateForm(int $id)
    // public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $id,
            // 'folder_id' => $folder->id,
        ]);
    }

    /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(int $id, CreateTask $request)
    // public function create(Folder $folder, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);
        // $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
            // 'id' => $folder->id,
        ]);
    }

    /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(int $id, int $task_id)
    // public function showEditForm(Folder $folder, Task $task)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, int $task_id, EditTask $request)
    // public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $task = Task::find($task_id);
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }

    // /**
    //  * フォルダとタスクの関連性があるか調べる
    //  * @param Folder $folder
    //  * @param Task $task
    //  */
    // private function checkRelation(Folder $folder, Task $task)
    // {
    //     if ($folder->id !== $task->folder_id) {
    //         abort(404);
    //     }
    // }
}
