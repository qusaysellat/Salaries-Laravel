@extends('layouts.app')
@section('title')
    {{$position->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$position->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    اسم المنظمة
                                </td>
                                <td>
                                    {{ $position->organization->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    الراتب الأساسي
                                </td>
                                <td>
                                    {{ $position->salary }} ل.س.
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    عدد الموظفين
                                </td>
                                <td>
                                    {{ $position->users()->count()}}
                                </td>
                            </tr>
                        </table>
                        <p class="h4">قائمة بالموظفين في هذا المستوى الوظيفي</p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center">المرتبة الوظيفية</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            <?php $i = 0; ?>
                            @foreach($position->users as $employee)
                                @if($employee->role==3)
                                    <tr>
                                        <td>{{$loop->iteration-$i}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->position->name}}</td>
                                        <td><a href="{{ route('employees.show',['id'=>$employee->id]) }}">أظهر</a></td>
                                    </tr>
                                @else
                                    <?php $i++; ?>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
                @if(Auth::user()->role==1)
                    <div class="panel panel-default">
                        <div class="panel-heading"><p class="h3">خيارات المستوى الوظيفي : {{$position->name}}</p></div>

                        <div class="panel-body">
                            <div class="alert alert-danger">
                                <form class="form-horizontal" method="POST" action="{{ route('positions.destroy',['position'=>$position->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="">
                                        <button class="btn btn-danger btn-block btn-lg">
                                            حذف
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="alert alert-warning">
                                <a href="{{ route('positions.edit',['position'=>$position->id]) }}"><button class="btn btn-warning btn-block btn-lg">تغيير الراتب الأساسي للمستوى</button></a>
                            </div>
                            <div class="alert alert-info">
                                <a href={{route('pchanges.create').'?position_id='.$position->id}}><button class="btn btn-primary btn-block btn-lg">إدخال إضافة/ضريبة
                                    جديد</button></a>
                            </div>
                            <div class="alert alert-info">
                                <a href={{route('pchanges.index').'?position_id='.$position->id}}><button class="btn btn-primary btn-block btn-lg">إدارة الإضافات
                                    والضرائب</button></a>
                            </div>
                            <a href="{{route('home')}}">
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
