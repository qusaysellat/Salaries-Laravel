@extends('layouts.app')
@section('title')
    {{$observer->name}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$observer->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-responsive" style="font-size: 150%;">
                            <tr>
                                <td class="active">
                                    عنوان المراقب
                                </td>
                                <td>
                                    {{ $observer->address }}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    رقم تلفون
                                </td>
                                <td>
                                    {{ $observer->phone}}
                                </td>
                            </tr>
                            <tr>
                                <td class="active">
                                    بريد الكتروني
                                </td>
                                <td>
                                    {{ $observer->email }}
                                </td>
                            </tr>
                        </table>
                        <p class="h4">قائمة بالمنظمات المراقبة</p>
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المنظمة</th>
                            </tr>
                            </thead>
                            @foreach($observer->observed as $org)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$org->name}}</td>
                                    </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @if(Auth::user()->role==0)
                    <div class="panel panel-default">
                        <div class="panel-heading"><p class="h3">خيارات للمراقب : {{$observer->name}}</p></div>

                        <div class="panel-body">

                            <div class="alert alert-danger">
                                <form class="form-horizontal" method="POST" action="{{ route('observers.destroy',['id'=>$observer->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="">
                                        <button class="btn btn-danger btn-block btn-lg">
                                            حذف
                                        </button>
                                    </div>
                                </form>
                            </div>


                            <table class="table table-bordered table-condensed table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">اسم المنظمة</th>
                                    <th class="text-center">الحركة المتاحة</th>
                                </tr>
                                </thead>
                                @foreach($organizations as $organization)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$organization->name}}</td>
                                        <td>
                                        <div class="text-center">
                                            <form class="form-horizontal" method="POST"
                                                  action="{{ route('observers.update',['id'=>$observer->id]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="organization" value="{{$organization->id}}"/>
                                                <input type="hidden" name="action" value="{{$observed[$organization->id]}}"/>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-warning btn-block">
                                                            @if($observed[$organization->id])
                                                                حذف
                                                                @else
                                                            إضافة
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <a href="{{route('observers.index')}}">
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
