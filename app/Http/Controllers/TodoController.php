<?php

namespace App\Http\Controllers;

use App\UserTodo;
use Illuminate\Http\Request;

use Validator;

class TodoController extends Controller
{
  public function index()
  {

    $userTodo = new UserTodo();

    $userTodos = $userTodo->getAllData();

    return view('todo.index', compact('userTodos'));

  }

  public function create(Request $request)
  {
    $userTodo = new UserTodo();

    $messages = [
      'title.required' => 'please fill in the :attribute',
      'content.required' => 'please fill in the :attribute',
    ];

    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'content' => 'required',
    ], $messages);

    if (!$validator->fails()) {
      $title = $request['title'];
      $content = $request['content'];

      $userTodo->addTitleAndContent($title, $content);

      $userTodos = $userTodo->getAllData();

      return response()->json($userTodos);
    }

    return response()->json([ "error" => $validator->errors() ]);
  }
}
