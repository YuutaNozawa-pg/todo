@extends('layout')

@section('title', 'Todo')


@section('content')
  <table class="table">
    <thead>
  　   <tr>
        <th>
          <h3></h3>
        </th>
        <th>
          <h3>ToDo</h3>
        </th>
        <th>
          <h3>Doing</h3>
        </th>
        <th>
          <h3>Done</h3>
        </th>
      </tr>
    </thead>
    <tbody class="todo-list">
      <!-- foreachディレクティブを使ってDBから一覧情報を表示する -->
      @for ($i = 0; $i < 15; $i++)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      @endfor
    </tbody>
  </table>

  <!-- 1.モーダル表示のためのボタン -->
   <button class="todo-write btn btn-outline-dark" data-toggle="modal" data-target="#modal-example">
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
             <button type="button" class="btn btn-outline-dark" data-dismiss="modal">閉じる</button>
             <button type="button" class="todo-write-save btn btn-outline-dark">保存</button>
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
  $(".todo-write-save").on("click", function() {
    let todoMessage = $(".modal-body").find("textarea").val();

    //$(".todo").append(todoMessageBody);
  });
}
</script>
