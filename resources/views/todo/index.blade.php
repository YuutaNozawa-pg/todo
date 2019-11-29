@extends('layouts.app')
@section('title', 'Todo')

@section('content')
  <table class="table table-bordered" style="width: 80%; margin: auto;">
    <thead style="background-color: rgba(0, 0, 0, 0.03)">
      <tr>
        <th>
          <h5>#</h5>
        </th>
        <th>
          <h5>Todo</h5>
        </th>
        <th>
          <h5>Doing</h5>
        </th>
        <th>
          <h5>Done</h5>
        </th>
      </tr>
    </thead>
    <tbody class="todo-group" data-group="{{ $groupId }}">
      <!-- foreachディレクティブを使ってDBから一覧情報を表示する -->
      @foreach ($todoContents as $todoContent)
      <tr class="todo-list">
        <td><input class="todo-checkbox" type="checkbox" value="{{ $todoContent->sequance }}"></td>
        @if ($todoContent->state == 0)
         <td class="todo" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo">{{ $todoContent->title }}</td>
        @else
         <td class="todo" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo"></td>
        @endif
        @if ($todoContent->state == 1)
         <td class="todo-doing" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo">{{ $todoContent->title }}</td>
        @else
         <td class="todo-doing" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo"></td>
        @endif
        @if ($todoContent->state == 2)
         <td class="todo-done" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo">{{ $todoContent->title }}</td>
        @else
         <td class="todo-done" data-sequance="{{ $todoContent->sequance }}" data-title="{{ $todoContent->title }}" data-content="{{ $todoContent->content }}" data-toggle="modal" data-target="#modal-detail-todo"></td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  <!-- 1.モーダル表示のためのボタン -->
  <button style="position: relative; right: 10%; top: 10px;" class="todo-write btn btn-outline-dark" data-toggle="modal" data-target="#modal-add-todo">Add</button>

  <button style="position: relative; left: 10%; top: 10px;" class="button-todo-update btn btn-outline-dark">Update</button>
  <button style="position: relative; left: 10%; top: 10px;" class="button-todo-delete btn btn-outline-dark">Delete</button>
  <div style="position: relative; left: 10%; top: 10px;" class="validate-title"></div>
  <div style="position: relative; left: 10%; top: 10px;" class="validate-content"></div>

  <!-- 2.Addモーダルの配置 -->
  <div class="modal fade" id="modal-add-todo" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h5>Write</h5>
          </div>
        </div>
        <div class="modal-body form-group">
          <p>Title</p>
          <textarea name="title" class="title form-control" cols="63"></textarea><br></br>
          <p>Content</p>
          <textarea name="content" class="content form-control" rows="6" cols="63"></textarea>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline-dark" data-dismiss="modal">Close</button>
          <button class="todo-write-save btn btn-outline-dark" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- 3.Editモーダルの配置 -->
  <div class="modal fade" id="modal-detail-todo" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h5>Edit</h5>
          </div><br/>
        </div>
        <div class="modal-body form-group">
          <p>Title</p>
          <textarea name="update-title" class="edit-title form-control" cols="63"></textarea><br></br>
          <p>Content</p><textarea name="update-content" class="edit-content form-control" rows="6" cols="63"></textarea>
        </div>
        <div class="modal-footer">
          <button class="todo-edit-close btn btn-outline-dark" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<script type="text/javascript">
  window.onload = function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //todoをdoing→doneに移動させるのに必要
    $(".todo-list").each(function(i, v){
      new Sortable(v,{
        animation: 200,
        draggable: ".todo, .todo-done, .todo-doing"
      });
    });

    //モーダル自体を動かすのに必要
    $("#modal-add-todo").draggable({ cursor: "move" });

    addTodo();

    updateTodo();

    detailTodo();

    deleteTodo();

  };

  function detailTodo() {
    let myRow;
    $("[data-target]").on("click", function() {
      $("[name=update-title]").val($(this).attr("data-title"));
      $("[name=update-content]").val($(this).attr("data-content"));
      myRow = $(this);
    });

    $(".todo-edit-close").on("click", function() {
      let title = $(".modal-body").find("textarea.edit-title").val();
      let content = $(".modal-body").find("textarea.edit-content").val();

      let todoRow = $(myRow).siblings();
      todoRow.push(myRow[0]);

      $(todoRow).each(function() {
        $(this).attr("data-title", title);
        $(this).attr("data-content", content);

        if ($(this).text() != "") {
          $(this).text(title);
        }
      });
    });
  }

  function updateTodo() {

    $(".button-todo-update").on("click", function(){

      let updateChecked = [];
      let updateTableRow = [];
      let updateStates = [];
      let updateTitles = [];
      let updateContents = [];
      $(".todo-checkbox").each(function(){
        //if ($(this).prop("checked")) {
          updateChecked.push($(this).val());
          updateTableRow.push($(this).parent().parent());
        //}
      });

      if (updateChecked.length == 0 ) {
        return;
      }

      let states = {
        1 : 0,
        2 : 1,
        3 : 2,
      };

      let state = 0;
      for (var i = 0; i < updateTableRow.length; i++) {
        for (var j = 1; j < 4; j++) {
          var table = $(updateTableRow[i]).children()[j];
          if ($(table).text() != "") {
            updateStates.push(states[j]);
            let title = $(updateTableRow[i].children()[j]).attr("data-title");
            let content = $(updateTableRow[i].children()[j]).attr("data-content");

            updateTitles.push(title);
            updateContents.push(content);
          }
        }
      }

      let updateTodo = {
        "sequance": updateChecked,
        "state": updateStates,
        "title": updateTitles,
        "content": updateContents,
        "_method": "PUT"
      };

      $.ajax({
        url: "/todo",
        type: "post",
        dataType: "json",
        data: updateTodo,
      }).done(function(data) {
        alert("Updated");
      }).fail(function(data) {
      });
    });
  }

  //Deleteを押す
  function deleteTodo() {

    $(".button-todo-delete").on("click", function() {

      let deleteChecked = [];
      let deleteTableRow = [];
      $(".todo-checkbox").each(function(){
        if ($(this).prop("checked")) {
          deleteChecked.push($(this).val());
          deleteTableRow.push($(this).parent().parent());
        }
      });

      if (deleteChecked.length == 0) {
        alert("削除する場合はチェックを入れてください");
        return;
      }

      $.ajax({
        url: "/todo",
        type: "post",
        dataType: "json",
        data: {
          "sequance": deleteChecked,
          "_method": "DELETE",
        },
      }).done(function(data) {
        for (var i = 0; i < deleteTableRow.length; i++) {
          deleteTableRow[i].remove();
        }

        alert("Deleted");
      }).fail(function() {
      });
    });
  }

  //Todoを書く
  function addTodo() {
    $(".todo-write-save").on("click", function() {

      let groupId = $(".todo-group").data("group");
      let title = $(".modal-body").find("textarea.title").val();
      let content = $(".modal-body").find("textarea.content").val();
      let maxValue = 0;
      $(".todo-checkbox").each(function(i, v) {
        const number = parseInt($(v).val());

        if (maxValue < number) {
          maxValue = number;
        }
      });

      maxValue++;

      const addTodo = {
        "groupId" : groupId,
        "sequance" : maxValue,
        "title" : title,
        "content" : content
      };

      console.log("a");

      $.ajax({
        url: "/todo",
        type: "post",
        dataType: "json",
        data: addTodo,
      }).done(function(data){
        if ('error' in data) {
          $('.validate-title').text("");
          $('.validate-content').text("");

          $('.validate-title').text(data.error.title);
          $('.validate-content').text(data.error.content);
          return;
        }

        $('.validate-title').text("");
        $('.validate-content').text("");

        $(".todo-group").append(`
            <tr class="todo-list">
              <td><input class="todo-checkbox" type="checkbox" value=` + maxValue + `></td>
              <td class="todo">` + title + `</td>
              <td class="todo-doing"></td>
              <td class="todo-done"></td>
            </tr>
        `);

        //todoをdoing→doneに移動させるのに必要
        $(".todo-list").each(function(i, v){
          new Sortable(v,{
            animation: 200,
            draggable: ".todo, .todo-done, .todo-doing"
          });
        });

        //todoをdoing→doneに移動させるのに必要

      }).fail(function(){
      });
    });
  }
</script>
