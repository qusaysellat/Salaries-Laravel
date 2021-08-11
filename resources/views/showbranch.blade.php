@extends('layouts.app')
@section('title')
    {{$branch->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$branch->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    اسم المنظمة
                                </td>
                                <td>
                                    {{ $branch->organization->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    عنوان الفرع
                                </td>
                                <td>
                                    {{ $branch->address }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    رقم تلفون
                                </td>
                                <td>
                                    {{ $branch->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    فاكس
                                </td>
                                <td>
                                    {{ $branch->fax }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    بريد الكتروني
                                </td>
                                <td>
                                    {{ $branch->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    عدد الموظفين
                                </td>
                                <td>
                                    {{ $branch->users()->count()-1 }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    اسم مدير الرواتب
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                            </tr>
                        </table>
                        <p class="h4">قائمة بالموظفين في هذا الفرع</p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center">المرتبة الوظيفية</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            <?php $i=0; ?>
                            @foreach($branch->users as $employee)
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
                        <div class="panel-heading"><p class="h3">خيارات للفرع : {{$branch->name}}</p></div>

                        <div class="panel-body">
                            <div class="alert alert-danger">
                                <form class="form-horizontal" method="POST" action="{{ route('branches.destroy',['branch'=>$branch->id]) }}">
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
                                <a href="{{ route('branches.edit',['branch'=>$branch->id]) }}"><button class="btn btn-warning btn-block btn-lg">تغيير مدير رواتب الفرع</button></a>
                            </div>
                            <div class="alert alert-info">
                                <a href="{{ route('audits.index').'?id='.$branch->id.'&type=3' }}"><button class="btn btn-primary btn-block btn-lg">مراقبة الحركات على
                                        موظفي هذا الفرع</button></a>
                            </div>
                            <a href="{{route('branches.index')}}">
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
