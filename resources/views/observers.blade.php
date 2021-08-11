@extends('layouts.app')
@section('title')
    Observers
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالمراقبين</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المراقب</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            @foreach($observers as $observer)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$observer->name}}</td>
                                    <td><a href="{{ route('observers.show',['id'=>$observer->id]) }}">أظهر</a> </td>
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
