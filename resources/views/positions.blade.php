@extends('layouts.app')
@section('title')
    Positions
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالمستويات الخاصة بالمنظمة</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المستوى</th>
                                <th class="text-center">الراتب الأساسي</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            @foreach($positions as $position)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$position->name}}</td>
                                    <td>{{$position->salary}}</td>
                                    <td><a href="{{ route('positions.show',['position'=>$position->id]) }}">أظهر</a> </td>
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
