@extends('layouts.app')
@section('content')


    <script src="{{ asset('/js/todo.js') }}" defer></script>

        <table>
                @foreach ($todo as $data)
                <tr id="todo{{$data->id}}">
                    <td>{{$data->id}}</td>
                    <td>{{$data->title}}</td>
                    <td>{{$data->description}}</td>
                </tr>
                @endforeach
        </table>

                                <input type="text"  id="title" name="title"
                                        placeholder="Enter title" value="">
                                    <input type="text"  id="description" name="description"
                                        placeholder="Enter Description" value="">
        <input type="text"  id="nobl" placeholder="Введіть область">

                        <button type="button" id="btn-save">Save</button>
                        <button type="button" id="btn-load">obl</button>

        <div id = 'msg'>This message will be replaced using Ajax.</div>
        <div id = 'rayc'></div>


@endsection
