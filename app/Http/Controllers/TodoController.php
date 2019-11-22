<?php

namespace App\Http\Controllers;

use App\UserTodo;
use Illuminate\Http\Request;

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

    $title = $request['title'];
    $content = $request['content'];

    $userTodo->addTitleAndContent($title, $content);

    return response()->json(['status' => 200, 'message' => 'success']);
  }
}
