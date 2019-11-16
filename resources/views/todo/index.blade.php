@extends('layout')

@section('title', 'Todo')


@section('content')
  <table style="margin: auto;">
    <thead>
  　   <tr>
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
    <tbody>
      <tr>
        <td><input type="text"></td>
        <td><input type="text"></td>
        <td><input type="text"></td>
      </tr>
    </tbody>
  </table>
@endsection
