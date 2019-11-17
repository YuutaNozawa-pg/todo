@extends('layout')

@section('title', 'Todo')


@section('content')
  <table style="margin: auto;">
    <thead>
  　   <tr>
        <th class="border border-dark rounded-top">
          <h3>ToDo</h3>
        </th>
        <th class="border border-dark rounded-top">
          <h3>Doing</h3>
        </th>
        <th class="border border-dark rounded-top">
          <h3>Done</h3>
        </th>
      </tr>
    </thead>
    <tbody id="todo-list">
      <!-- foreachディレクティブを使ってDBから一覧情報を表示する -->
    </tbody>
  </table>

  <!-- 1.モーダル表示のためのボタン -->
   <button style="float: right;" class="btn btn-primary" data-toggle="modal" data-target="#modal-example">
       Todoを書く
   </button>

   <!-- 2.モーダルの配置 -->
   <div class="modal" id="modal-example" tabindex="-1">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-body">
             <p>今日のTodoを書く<br>
               <textarea rows="6" cols="63"></textarea>
             </p>
         </div>

         <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
             <button type="button" class="todo-write btn btn-primary">保存</button>
         </div>
       </div>
     </div>
   </div>
@endsection

<script>
window.onload = function() {
  addTodo();
};

function addTodo() {
  $(".todo-write").on("click", function() {
    let todoMessage = $(".modal-body").find("textarea").val();
    let todoMessageBody = `
      <tr>
        <td>` + todoMessage + `</td>
      </tr>
    `;

    $("#todo-list").append(todoMessageBody);
  });
}
</script>
