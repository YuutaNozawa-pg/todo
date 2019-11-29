<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use App\TodoContent;
use Tests\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
      $todoContent = new TodoContent();

      //リクエストに使うパラメーター
      $sequance = array(10000, 20000);
      $state = array(1, 2);
      $title = array("テストタイトルA", "テストタイトルB");
      $content = array("テストタイトルA", "テストタイトルB");

      //テスト用に登録したレコード
      $todoContent->create([
        'sequance' => 10000,
        'title' => "テストタイトルA",
        'content' => "テストタイトルB",
        'state' => 0
        ]);

      $todoContent->create([
        'sequance' => 20000,
        'title' => "テストタイトルA",
        'content' => "テストタイトルB",
        'state' => 0
        ]);

      //リクエストヘッダーとパラメーター
      $response = $this->withHeaders([
          'Content-type' => 'application/json'
        ])->json('PUT', '/todo', [
          'sequance' => $sequance,
          'state' => $state,
          'title' => $title,
          'content' => $content
        ]);

      Log::debug($todoContent->getAllData());

      //何事もなければ200が返ってくるはず
      $response->assertStatus(200);

      //追加したデータの削除
      $todoContent->whereIn('sequance', [10000, 20000])->delete();
    }
}
