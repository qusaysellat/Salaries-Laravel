@extends('layouts.app')
@section('title')
    Employee
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">اختر الفعل الذي تود القيام به</p> </div>

                    <div class="panel-body">
                        <div class="alert alert-info">
                            <a href={{route('employees.show',['id'=>Auth::user()->id])}}><button class="btn btn-primary btn-block btn-lg">إظهار بطاقة الراتب</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('notifications')}}><button class="btn btn-primary btn-block btn-lg">إظهار الاشعارات</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
