@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">端口管理</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/tcp/add" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('name')) has-error @endif">
                    <label>名称：</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('ip')) has-error @endif">
                    <label>IP：</label>
                    <input type="text" class="form-control ui-state-error" name="ip"
                           value="{{old('ip')?:'0.0.0.0'}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('port')) has-error @endif">
                    <label>端口：</label>
                    <input type="text" class="form-control ui-state-error" name="port"
                           value="{{old('port')}}">
                </div>
                <div class="form-group m-r-10">
                    <label>主机组:</label>
                    <select class="form-control" name="backend">
                        @foreach($backends as $b)
                            <option value="{{$b->id}}">[{{$b->type}}] {{$b->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5" style="float: right;">添加</button>
            </form>
        </div>
    </div>
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>IP</th>
                    <th>端口</th>
                    <th>主机组</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->name}}}</td>
                        <td>{{{$v->ip}}}</td>
                        <td>{{$v->port}}</td>
                        <td><a href="/admin/tcp/backend/detail?id={{{$v->backend->id}}}">{{$v->backend->name}}</a></td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/tcp/del?id={{{$v->id}}}'">删除</a>]
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection