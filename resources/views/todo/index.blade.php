@extends('layout')

@section('title', 'Todo')


@section('content')
  <table class="table">
    <thead>
  　   <tr>
        <th>
          <h5></h5>
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
    <tbody class="todo-group">
      <!-- foreachディレクティブを使ってDBから一覧情報を表示する -->
      @foreach ($userTodos as $userTodo)
      <tr class="todo-list">
        <td class="todo-number">{{ $userTodo->id }}</td>
        <td class="todo">{{ $userTodo->title }}</td>
        <td></td>
        <td></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <!-- 1.モーダル表示のためのボタン -->
   <button class="todo-write btn btn-outline-dark" data-toggle="modal" data-target="#modal-add-todo">
       Todoを書く
   </button>

   <!-- 2.モーダルの配置 -->
   <div class="modal" id="modal-add-todo" tabindex="-1">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <div class="modal-title"><h5>今日のTodoを書く</h5></div>
         </div>
         <div class="modal-body form-group">
             <p><p>タイトル</p>
               <textarea class="title form-control" cols="63"></textarea>
             </p>
             <p><p>本文</p>
               <textarea class="content form-control" rows="6" cols="63"></textarea>
             </p>
         </div>

         <div class="modal-footer">
             <button type="button" class="btn btn-outline-dark" data-dismiss="modal">閉じる</button>
             <button type="button" class="todo-write-save btn btn-outline-dark" data-dismiss="modal">保存</button>
         </div>
       </div>
     </div>
   </div>
@endsection

<script>
window.onload = function() {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //todoをdoing→doneに移動させるのに必要
  $(".todo-list").sortable();

  //モーダル自体を動かすのに必要
  $("#modal-add-todo").draggable({ cursor: "move" });

  addTodo();
};

//Todoを書く
function addTodo() {
  $(".todo-write-save").on("click", function() {
    let title = $(".modal-body").find("textarea.title").val();
    let content = $(".modal-body").find("textarea.content").val();

    const userTodo = {
      "title" : title,
      "content" : content
    };

    $.ajax({
      url: "/todo",
      type: "post",
      dataType: "json",
      data: userTodo,
    }).done(function(data){
      let maxValue = 0;
      $(".todo-number").each(function(i, v) {
        const number = parseInt($(v).text());

        if (maxValue < number) {
          maxValue = number;
        }
      });

      maxValue++;

      $(".todo-group").append(`
          <tr class="todo-list">
            <td class="todo-number">` + maxValue + `</td>
            <td class="todo">` + title + `</td>
            <td></td>
            <td></td>
          </tr>
      `);

    }).fail(function(){

    });
  });
}
</script>
