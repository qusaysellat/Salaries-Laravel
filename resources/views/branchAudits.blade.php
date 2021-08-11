@extends('layouts.app')
@section('title')
    Branches Audits
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">قائمة بالحركات على الأفرع التابعة للمنظمة :  {{$item->name}} ، والتي يدير حسابها المستخدم : {{$user->name}}</p></div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped table-responsive">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الفرع</th>
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
                        <a href="{{route('organizations.show',['organization'=>$item->id])}}">
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
