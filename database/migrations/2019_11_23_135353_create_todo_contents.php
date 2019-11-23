<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_contents', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable(false);
            $table->bigInteger('sequance')->nullable(false);
            $table->char('title', 128)->nullable(false);
            $table->text('content', 256)->nullable(false);
            $table->bigInteger('state')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_contents');
    }
}
