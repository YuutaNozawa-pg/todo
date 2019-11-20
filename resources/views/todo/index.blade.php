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
          <h5>ToDo</h5>
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
      @for ($i = 0; $i < 15; $i++)
        <tr class="todo-list">
          <td class="todo-number">{{ $i + 1 }}</td>
          <td class="todo"></td>
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
  addTodo();
};

//Todoを書く
function addTodo() {
  $(".todo-write-save").on("click", function() {
    let todoMessageTitle = $(".modal-body").find("textarea.title").val();
    let todoMessageContent = $(".modal-body").find("textarea.content").val();

    //一覧のリストをforeachで回す
    $(".todo").each(function(i, v) {
      //一覧から空白が見つかり次第
      if ($(v).text() == "") {
        //tdの中にタイトルを突っ込んでいる
        $(v).text(todoMessageTitle);
        return false;
      }
    });
  });
}
</script>
