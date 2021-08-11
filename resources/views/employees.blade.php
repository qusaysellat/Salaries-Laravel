@extends('layouts.app')
@section('title')
    Employees
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالموظفين في الفرع</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center">المرتبة الوظيفية</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->position->name}}</td>
                                    <td><a href="{{ route('employees.show',['id'=>$employee->id]) }}">أظهر</a> </td>
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
