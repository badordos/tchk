@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-2">
                <form method="GET" action="{{route('tasks.search')}}" enctype="multipart/form-data">
                    <div class="input-group input-group-sm mb-3">
                        <input name="title" type="text" class="form-control" aria-label="Sizing example input"
                               aria-describedby="inputGroup-sizing-sm">
                        <button class="btn btn-sm btn-primary" type="submit">Найти</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr data-id="{{$task->id}}">
                            <td>{{$task->id}}</td>
                            <td>{{$task->title}}</td>
                            <td>{{$task->date->format('d.m.Y h:i')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$tasks->links()}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="date"></p>
                    <p id="author"></p>
                    <p id="status"></p>
                    <p id="description"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/modal.js') }}" defer></script>
@endsection
