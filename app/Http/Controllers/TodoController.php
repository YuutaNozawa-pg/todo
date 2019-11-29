<?php

namespace App\Http\Controllers;

use App\UserTodo;
use App\UserGroupTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;
use Validator;

class TodoController extends Controller
{
  public function index(Request $request)
  {
    $todoContent= new UserGroupTodo();

    $groupId = $request['id'];

    if ($todoContent::find($groupId) == null) {
      return redirect("/home");
    }

    $userTodoContents = $todoContent::find($groupId);

    $todoContents = $userTodoContents->userTodos;

    return view('todo.index', compact('todoContents', 'groupId'));
  }

  public function create(Request $request)
  {
    $todoContent = new UserTodo();

    $messages = [
      'title.required' => 'please fill in the :attribute',
      'content.required' => 'please fill in the :attribute',
    ];

    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'content' => 'required',
    ], $messages);

    if ($validator->fails()) {
      return response()->json([ "error" => $validator->errors() ]);
    }

    $userId = Auth::User()->id;
    $groupId = $request['groupId'];
    $sequance = $request['sequance'];
    $title = $request['title'];
    $content = $request['content'];

    $todoContent->addTitleAndContent($userId, $groupId, $sequance, $title, $content);

    $todoContents = $todoContent->getAllData();

    return response()->json($todoContents);
  }

  public function update(Request $request)
  {
    $todoContent = new UserTodo();

    $sequance = $request['sequance'];
    $state = $request['state'];
    $title = $request['title'];
    $content = $request['content'];

    $todoContent->updateContent($sequance, $state, $title, $content);

    return response()->json($request->all());
  }

  public function delete(Request $request)
  {
    $todoContent = new UserTodo();

    $todoContent->deleteContent($request['sequance']);

    return response()->json($request->all());
  }
}
