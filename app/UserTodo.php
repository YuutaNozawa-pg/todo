<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTodo extends Model {

  protected $fillable = [
    'user_id',
    'group_id',
    'sequance',
    'title',
    'content',
    'state',
  ];

  //ユーザーに紐づかせた全データを取得
  public function getAllData() {
    return $this->get();
  }

  //ユーザーに紐づかせたデータを1件追加
  public function addTitleAndContent($userId, $groupId, $sequance, $title, $content) {
    DB::transaction(function() use ($userId, $groupId, $sequance, $title, $content) {
      $this->create([
          'user_id' => $userId,
          'group_id' => $groupId,
          'sequance' => $sequance,
          'title' => $title,
          'content' => $content,
          'state' => 0
        ]);
    });
  }

  public function updateContent($sequance, $state, $title, $content) {
    DB::transaction(function() use ($sequance, $state, $title, $content) {
      foreach ($sequance as $key => $value) {
        $this->where('sequance', $value)
             ->update([
               'state' => $state[$key],
               'title' => $title[$key],
               'content' => $content[$key]
             ]);
      }
    });
  }

  public function deleteGroupContent($userId, $groupId) {
    DB::transaction(function() use ($userId, $groupId) {
      $this->where([
        'user_id' => $userId,
        'group_id' => $groupId
      ])->delete();
    });
  }

  //ユーザーIDに紐づくデータを削除したい
  public function deleteContent($sequance) {
    DB::transaction(function() use ($sequance) {
      $this->whereIn('sequance', $sequance)
           ->delete();
    });
  }
}
