@extends('layouts.app')
@section('title')
    Organizations
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالمنظمات التي تم إنشاءها</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المنظمة</th>
                                <th class="text-center">استعراض</th>
                                <th class="text-center">إظهار التقرير</th>
                            </tr>
                            </thead>
                            @foreach($organizations as $organization)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$organization->name}}</td>
                                    <td><a href="{{ route('organizations.show',['organization'=>$organization->id]) }}">أظهر</a> </td>
                                    <td><a href="{{ route('report',['id'=>$organization->id]) }}">التقرير</a> </td>
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
