<?php

namespace App\Http\Controllers;

use App\TodoContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;
use Validator;

class TodoController extends Controller
{
  public function index()
  {

    $todoContent= new TodoContent();

    $todoContents = $todoContent->getAllData();

    return view('todo.index', compact('todoContents'));

  }

  public function create(Request $request)
  {
    $todoContent = new TodoContent();

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

    $sequance = $request['sequance'];
    $title = $request['title'];
    $content = $request['content'];

    $todoContent->addTitleAndContent($sequance, $title, $content);

    $todoContents = $todoContent->getAllData();

    return response()->json($todoContents);
  }

  public function update(Request $request)
  {
    $todoContent = new TodoContent();

    $sequance = $request['sequance'];
    $state = $request['state'];
    $title = $request['title'];
    $content = $request['content'];

    $todoContent->updateContent($sequance, $state, $title, $content);

    return response()->json($request->all());
  }

  public function delete(Request $request)
  {
    $todoContent = new TodoContent();

    $todoContent->deleteContent($request['sequance']);

    return response()->json($request->all());
  }
}
