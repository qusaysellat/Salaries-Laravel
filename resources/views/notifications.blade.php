@extends('layouts.app')
@section('title')
    Notifications
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالاشعارات الخاصة بك</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">نص الاشعار</th>
                                <th class="text-center">التاريخ</th>
                            </tr>
                            </thead>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$notification->text}}</td>
                                    <td>{{$notification->created_at}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="{{route('home')}}">
                            <button type="button" class="btn btn-success">
                                تراجع
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
