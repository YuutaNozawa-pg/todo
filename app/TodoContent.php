<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TodoContent extends Model {

  protected $fillable = [
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
  public function addTitleAndContent($sequance, $title, $content) {
    DB::transaction(function() use ($sequance, $title, $content) {
      $this->create([
          'sequance' => $sequance,
          'title' => $title,
          'content' => $content,
          'state' => 0
        ]);
    });
  }

  public function updateContent($sequance, $state) {
    DB::transaction(function() use ($sequance, $state) {
      $this->where('sequance', '=', $sequance)
           ->update(['state' => $state]);
    });
  }

  //ユーザーIDに紐づくデータを削除したい
  public function deleteContent($sequance) {
    DB::transaction(function() use ($sequance) {
      $this->where('sequance', '=', $sequance)
           ->delete();
    });
  }
}
