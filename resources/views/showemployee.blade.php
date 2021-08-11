@extends('layouts.app')
@section('title')
    {{$employee->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">بطاقة راتب للموظف : {{$employee->name}}</p></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    رقم الضمان الاجتماعي
                                </td>
                                <td>
                                    {{ $employee->username }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
اسم المنظمة
                                </td>
                                <td>
                                    {{ $employee->organization->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    اسم الفرع
                                </td>
                                <td>
                                    {{ $employee->branch->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    عنوان الموظف
                                </td>
                                <td>
                                    {{ $employee->address }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    رقم تلفون
                                </td>
                                <td>
                                    {{ $employee->phone }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    بريد الالكتروني
                                </td>
                                <td>
                                    {{ $employee->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    اسم المستوى الوظيفي
                                </td>
                                <td>
                                    {{ $employee->position->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    الراتب الأساسي
                                </td>
                                <td>
                                    {{ $employee->position->salary }} ل.س.
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    الراتب النهائي
                                </td>
                                <td>
                                    {{ $total }} ل.س.
                                </td>
                            </tr>
                        </table>
                        <p class="h4">
                            الإضافات والضرائب الخاصة بالمستوى الوظيفي:
                        </p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الإضافة/الضريبة</th>
                                <th class="text-center">النوع</th>
                                <th class="text-center">نسبة مئوية؟</th>
                                <th class="text-center">القيمة</th>
                                <th class="text-center">القيمة بالليرة</th>
                            </tr>
                            </thead>
                            @foreach($employee->position->changes as $change)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$change->name}}</td>
                                    <td>
                                        @if($change->type==0)
                                            إضافة
                                        @else
                                            ضريبة
                                        @endif
                                    </td>
                                    <td>
                                        @if($change->percentage==0)
                                            لا
                                        @else
                                            نعم
                                        @endif
                                    </td>
                                    <td>{{$change->value}}</td>
                                    <td>
                                        {{$changes1[$change->id]}} ل.س.
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <p class="h4">
                            الإضافات والحسميات الخاصة بالموظف:
                        </p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الإضافة/الحسمية</th>
                                <th class="text-center">النوع</th>
                                <th class="text-center">نسبة مئوية؟</th>
                                <th class="text-center">القيمة</th>
                                <th class="text-center">القيمة بالليرة</th>
                            </tr>
                            </thead>
                            @foreach($employee->changes as $change)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$change->name}}</td>
                                    <td>
                                        @if($change->type==0)
                                            إضافة
                                        @else
                                            حسمية
                                        @endif
                                    </td>
                                    <td>
                                        @if($change->percentage==0)
                                            لا
                                        @else
                                            نعم
                                        @endif
                                    </td>
                                    <td>{{$change->value}}</td>
                                    <td>
                                        {{$changes2[$change->id]}} ل.س.
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @if(Auth::user()->role==2)
                    <div class="panel panel-default">
                        <div class="panel-heading"><p class="h3">خيارات للموظف : {{$employee->name}}</p></div>
                        <div class="panel-body">

                            <div class="alert alert-danger">
                                <form class="form-horizontal" method="POST" action="{{ route('employees.destroy',['employee'=>$employee->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="">
                                        <button class="btn btn-danger btn-block btn-lg">
                                            حذف
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="alert alert-info">
                                <a href={{route('uchanges.create').'?employee_id='.$employee->id}}><button class="btn btn-primary btn-block btn-lg">إدخال إضافة/حسمية
                                        جديد</button></a>
                            </div>
                            <div class="alert alert-info">
                                <a href={{route('uchanges.index').'?employee_id='.$employee->id}}><button class="btn btn-primary btn-block btn-lg">إدارة الإضافات
                                        والحسميات</button></a>
                            </div>
                            <a href="{{route('employees.index')}}">
                                <button type="button" class="btn btn-success">
                                    تراجع
                                </button>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
