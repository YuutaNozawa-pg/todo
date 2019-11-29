<?php

namespace App;

use App\UserTodo;
use Illuminate\Database\Eloquent\Model;
use Log;

class UserGroupTodo extends Model
{
    //
    protected $fillable = [
      'user_id',
      'name'
    ];

    public function getAllData($userId) {
      return $this->where(['user_id' => $userId])->get();
    }

    public function add($userId) {
      return $this->create([
        'user_id' => $userId,
        'name' => '',
      ]);
    }

    public function updateTodo($userId, $ids, $names) {
      for ($i = 0; $i < count($ids); $i++) {
        $this->where([
          'id' => $ids[$i],
          'user_id' => $userId,
        ])->update([
          'name' => $names[$i]
        ]);
      }
    }

    public function deleteTodo($userId, $id) {
      $this->where([
        'id' => $id,
        'user_id' => $userId,
        ])->delete();
    }

    public function userTodos()
    {
      return $this->hasMany(UserTodo::class, 'group_id');
    }
}
