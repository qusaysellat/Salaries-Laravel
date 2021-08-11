@extends('layouts.app')
@section('title')
    Changes
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">{{$item->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الإضافة/الحسمية</th>
                                <th class="text-center">النوع</th>
                                <th class="text-center">نسبة مئوية؟</th>
                                <th class="text-center">القيمة</th>
                            </tr>
                            </thead>
                            @foreach($changes as $change)
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
                                        <form class="form-horizontal" method="POST" action="{{ route('uchanges.destroy',['pchange'=>$change->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-danger">
                                                        حذف
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="{{route('employees.index')}}">
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
