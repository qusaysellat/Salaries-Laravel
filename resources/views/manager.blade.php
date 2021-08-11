@extends('layouts.app')
@section('title')
    Manager
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">مدير حساب المنظمة : اختر الفعل الذي تود القيام به</p> </div>

                    <div class="panel-body">
                        <div class="alert alert-info">
                            <a href={{route('organizations.show',['organization'=>$item->id])}}><button class="btn btn-primary btn-block btn-lg">استعراض المنظمة</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('positions.create')}}><button class="btn btn-primary btn-block btn-lg">إنشاء مستوى وظيفي جديد</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('positions.index')}}><button class="btn btn-primary btn-block btn-lg">إدارة المستويات الوظيفية</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('branches.create')}}><button class="btn btn-primary btn-block btn-lg">إنشاء فرع جديد للمنظمة</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href={{route('branches.index')}}><button class="btn btn-primary btn-block btn-lg">إدارة فروع المنظمة</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
