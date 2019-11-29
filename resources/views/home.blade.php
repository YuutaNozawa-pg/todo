@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List
                  <button class="add btn btn-outline-dark" style="float: right;">Add</button>
                  <button data-state="edit" class="edit btn btn-outline-dark" style="margin-right: 10px; float: right;">Edit</button>
                </div>

                @foreach ($contents as $content)
                <div class="card-body" style="border-top: 1px solid gray;">
                   <a data-id="{{ $content->id }}" class="todo-name" href="/todo/{{ $content->id }}">{{ $content->name }}</a>
                   <button data-ids="{{ $content->id }}" class="delete btn btn-outline-dark" style="float: right;">×</button>
                </div>
                @endforeach
            </div>
            <br/>
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

  editTodo();
  createTodo();
  destroyTodo();

  function editTodo()
  {
    $(".edit").on("click", function() {
      let state = 0;
      let updateIds = [];
      let updateNames = [];
      if ($(this).text() == "Edit") {
          let card = $(this).parent().siblings();

          let name = $(card).children('.todo-name').text();

          let id = 0;

          $('.todo-name').each(function() {
            let name = $(this).text();
            let id = $(this).data("id");
            $(this).after(`<input data-id=` + id + ` class="title" type="text" style="width: 90%;" value=` + name + `>`);
          });

          $(card).children('.todo-name').remove();
          state = 1;
      }

      if (state == 0) {

        $(this).prop('disabled', true);
        let button = $(this);
        $('.title').each(function(i, v) {
          updateIds.push($(v).data("id"));
          updateNames.push($(v).val());
        });

        const updateTodo = {
          "ids": updateIds,
          "names": updateNames,
          "_method": "PUT"
        };

        if (updateTodo.ids.length != 0) {
          $.ajax({
            url: "/home",
            type: "post",
            data: updateTodo,
            dataType: "json",
          }).done(function(data) {
            $('.title').each(function(i, v){
              $(v).after(`
                <a data-id=` + $(v).data("id") + ` class="todo-name" href="/todo/` + $(v).data("id") + `">` + $(v).val() + `</a>
              `);
              $(v).remove();
            });

            $(button).prop('disabled', false);
            console.log(data);
          }).fail(function() {
            $(button).prop('disabled', false);

          });
        } else {
          $(button).prop('disabled', false);
        }

        $(this).text("Edit");
      }

      if (state == 1) {
        $(this).text("Update");
      }

    });
  }
  function destroyTodo()
  {
    $(document).on("click", '.delete', function() {
      const deleteIds = {
        "id": $(this).data("ids"),
        "_method": "DELETE"
      }

      let deleteRow = $(this);

      $.ajax({
        url: "/home",
        type: "post",
        data: deleteIds,
        dataType: "json",
      }).done(function(data) {
        $(deleteRow).parent().remove();
      }).fail(function(data) {
      });
    });
  }

  function createTodo()
  {
    $(".add").on("click", function() {
      $.ajax({
        url: "/home",
        type: "post",
        dataType: "json",
      }).done(function(data) {
        if ($('.edit').text() == "Update") {
          $(".card").append(`
            <div class="card-body" style="border-top: 1px solid gray;">
              <input data-id=` + data.id + ` class="title" type="text" style="width: 90%; value="` + data.name + `">
              <button data-ids=` + data.id + ` class="delete btn btn-outline-dark" style="float: right;">×</button>
            </div>
         `);
        }
        if ($('.edit').text() == "Edit") {
          $(".card").append(`
            <div class="card-body" style="border-top: 1px solid gray;">
               <a data-id=` + data.id + ` class="todo-name" href="/todo/` + data.id + `">` + data.name + `</a>
               <button data-ids=` + data.id + ` class="delete btn btn-outline-dark" style="float: right;">×</button>
            </div>
          `);
        }
      }).fail(function() {

      });
    });
  }
};
</script>
