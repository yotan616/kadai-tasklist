<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
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
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);

        $task = new Task;
        $task->user_id = \Auth::user()->id;  // \Auth::user()->id  これで今ログインしてるユーザIDがとれる
        $task->status = $request->status;    // view のフォームで送信されたデータを受け取ってる
        $task->content = $request->content;  // view のフォームで送信されたデータを受け取ってる
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)  // $id には何が入る？   http://hogehoge.com/tasks/13
    {
        $user = \Auth::user();  // 今ログインしてるユーザ
        $task = Task::find($id);  // 13番目のタスクを取ってくる
        
        // 自分のタスク？　○なら表示　×ならトップページへ
        // １、タスクの持ち主のID ー＞ $task->user_id
        // ２、ログインしているユーザID ー＞ \Auth::user()->id
        
        if ($task->user_id == \Auth::user()->id) {  // ログインしているユーザのタスク？
            // ログインしている人が自分のタスクを見ようとしている
            return view('tasks.show',[ 'task' => $task, ]);
        } else {
            // elseの中にくる人は
            // ログインしている人で自分以外のタスクを見ようとしている
            //  -> URLが / に飛ぶ
            
            return redirect('/');    
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
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
        $this->validate($request, [
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        $task = Task::find($id);
        if ($task->user_id == \Auth::user()->id) { 
            // ログインしているユーザが自分のタスクを操作する
            // 指定したタスクの更新をする
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
            return redirect('/');
            
        } else {
            return redirect('/');    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)  // $id にタスク番号が入ってくる
    {
        $task = Task::find($id);
        if ($task->user_id == \Auth::user()->id) { 
            // ログインしているユーザが自分のタスクを操作する
            // 指定したタスクの削除をする
            $task->delete();
            return redirect('/');
            
        } else {
            return redirect('/');    
        }
       
    }
}
