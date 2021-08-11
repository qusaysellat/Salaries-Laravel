@extends('layouts.app')
@section('title')
    {{$organization->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$organization->name}}</p> </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    عنوان المنظمة
                                </td>
                                <td>
                                    {{ $organization->address }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    رقم تلفون
                                </td>
                                <td>
                                    {{ $organization->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    فاكس
                                </td>
                                <td>
                                    {{ $organization->fax }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    بريد الكتروني
                                </td>
                                <td>
                                    {{ $organization->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    عدد الموظفين
                                </td>
                                <td>
                                    {{ $organization->users()->count()-1-$organization->branches()->count()}}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    اسم مدير حساب المنظمة
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                            </tr>
                        </table>
                        <p class="h4">قائمة بالمستويات الوظيفية في المنظمة : </p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المستوى</th>
                                <th class="text-center">الراتب الأساسي</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            @foreach($organization->positions as $position)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$position->name}}</td>
                                    <td>{{$position->salary}}</td>
                                    <td><a href="{{ route('positions.show',['position'=>$position->id]) }}">أظهر</a> </td>
                                </tr>
                            @endforeach
                        </table>
                        <p class="h4">قائمة بالفروع التابعة للمنظمة : </p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الفرع</th>
                                <th class="text-center">استعراض</th>
                            </tr>
                            </thead>
                            @foreach($organization->branches as $branch)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$branch->name}}</td>
                                    <td><a href="{{ route('branches.show',['branch'=>$branch->id]) }}">أظهر</a> </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @if(Auth::user()->role==0)
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">خيارات المنظمة : {{$organization->name}}</p> </div>

                    <div class="panel-body">
                        <div class="alert alert-danger">
                            <form class="form-horizontal" method="POST" action="{{ route('organizations.destroy',['organization'=>$organization->id]) }}">
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
                            <a href="{{ route('organizations.edit',['organization'=>$organization->id]) }}"><button class="btn btn-warning btn-block btn-lg">تغيير مدير حساب المنظمة</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href="{{ route('audits.index').'?id='.$organization->id.'&type=1' }}"><button class="btn btn-primary btn-block btn-lg">مراقبة الحركات على المستويات الوظيفية</button></a>
                        </div>
                        <div class="alert alert-info">
                            <a href="{{ route('audits.index').'?id='.$organization->id.'&type=2' }}"><button class="btn btn-primary btn-block btn-lg">مراقبة الحركات على أفرع المنظمة</button></a>
                        </div>
                        <a href="{{route('organizations.index')}}">
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