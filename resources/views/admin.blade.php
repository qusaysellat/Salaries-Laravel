@extends('layouts.app')
@section('title')
    Admin
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">مدير الموقع : اختر الفعل الذي تود القيام به</p> </div>

                    <div class="panel-body">
                       <div class="alert alert-info">
                           <a href={{route('organizations.create')}}><button class="btn btn-primary btn-block btn-lg"> إنشاء منظمة جديدة</button></a>
                       </div>
                        <div class="alert alert-info">
                            <a href={{route('organizations.index')}}><button class="btn btn-primary btn-block btn-lg">إدارة المنظمات</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('observers.create')}}><button class="btn btn-primary btn-block btn-lg">إنشاء مراقب جديد</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('observers.index')}}><button class="btn btn-primary btn-block btn-lg">إدارة المراقبين</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
