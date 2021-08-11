@extends('layouts.app')
@section('title')
    Choose Report Type
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><p class="h3">اختر شكل التقرير</p> </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('showreport') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">الفرع المطلوب</label>
                                <div class="col-md-6">
                                    <select name="branch" class="form-control">
                                        <option value="0">كل الفروع</option>
                                        @foreach($organization->branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">المستوى الوظيفي المطلوب</label>
                                <div class="col-md-6">
                                    <select name="position" class="form-control">
                                        <option value="0">كل المستويات</option>
                                        @foreach($organization->positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="organization" value="{{$organization->id}}"/>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        أظهر
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="{{route('organizations.index')}}">
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
