<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    //
    public function testUpdate()
    {
      $sequance = array("1", "2");
      $state = array("1", "2");
      $title = array("テストタイトルA", "テストタイトルB");
      $content = array("テストタイトルA", "テストタイトルB");


      $response = $this->withHeaders([
      ])->json('PUT', '/todo', [
        'sequance' => $sequance,
        'state' => $state,
        'title' => $title,
        'content' => $content
      ]);

      $response->assertStatus(419);
    }
}
