@extends('layouts.app')
@section('title')
    Employees Audits
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالحركات على الموظفين التابعين للفرع :  {{$item->name}} ، والذي يدير رواتبه المستخدم : {{$user->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الموظف</th>
                                <th class="text-center">الحركة</th>
                                <th class="text-center">الختم الزمني</th>
                            </tr>
                            </thead>
                            @foreach($audits as $audit)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$audit->name}}</td>
                                    <td>{{$audit->text}}</td>
                                    <td>{{$audit->created_at}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="{{route('branches.show',['branch'=>$item->id])}}">
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
