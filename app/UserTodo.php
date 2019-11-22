<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTodo extends Model {

  protected $fillable = [
    'title',
    'content'
  ];

  //全件取得
  public function getAllData() {
    return $this->get();
  }

  //1件データを追加
  public function addTitleAndContent($title, $content) {
    DB::transaction(function() use ($title, $content) {
      $this->create([
          'title' => $title,
          'content' => $content
        ]);
    });
  }
}
