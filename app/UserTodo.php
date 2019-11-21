<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTodo extends Model {

  //全件取得
  public function getAllData() {
    return $this->get();
  }

  //1件データを追加
  public function addTitleAndContent($title, $content) {
    $this->insert([
      'title' => $title,
      'content' => $content
    ]);
  }
}
