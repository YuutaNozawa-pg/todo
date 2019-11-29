<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserGroupTodo;
use App\UserTodo;

use Log;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userGroupTodo = new UserGroupTodo();
        $userId = Auth::User()->id;

        $contents = $userGroupTodo->getAllData($userId);

        return view('home', compact('contents'));
    }

    public function create(Request $request)
    {

        $userGroupTodo = new UserGroupTodo();
        $userId = Auth::User()->id;
        $response = [
          'status' => 200,
          'message' => '成功'
        ];

        $userTodo = $userGroupTodo->add($userId);

        return response()->json($userTodo);
    }

    public function update(Request $request)
    {
      $userGroupTodo = new UserGroupTodo();
      $userId = Auth::User()->id;
      $response = [
        'status' => 200,
        'message' => '成功'
      ];

      $validator = Validator::make($request->all(), [
        'ids' => 'required|array',
        'ids.*' => 'integer',
        'names' => 'required|array',
        'names.*' => 'string',
      ]);

      if ($validator->fails()) {
        $response['status'] = 500;
        $response['message'] = '更新する際は必ず値を入力してください';
        return response()->json($response);
      }

      $userGroupTodo->updateTodo($userId, $request['ids'], $request['names']);

      return response()->json($response);
    }

    public function delete(Request $request)
    {
      $userGroupTodo = new UserGroupTodo();
      $userId = Auth::User()->id;
      $response = [
        'status' => 200,
        'message' => '成功'
      ];

      $userGroupTodo->deleteTodo($userId, $request['id']);

      $userTodo = new UserTodo();
      $userTodo->deleteGroupContent($userId, $request['id']);


      return response()->json($response);
    }
}
