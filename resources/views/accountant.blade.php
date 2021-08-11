@extends('layouts.app')
@section('title')
    Accountant
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">مدير رواتب الفرع : اختر الفعل الذي تود القيام به</p> </div>

                    <div class="panel-body">
                        <div class="alert alert-info">
                            <a href={{route('branches.show',['branch'=>$item->id])}}><button class="btn btn-primary btn-block btn-lg">استعراض الفرع</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('employees.create')}}><button class="btn btn-primary btn-block btn-lg">إدخال موظف جديد للفرع</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('employees.index')}}><button class="btn btn-primary btn-block btn-lg">إدارة الموظفين</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
