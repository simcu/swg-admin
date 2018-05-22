@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">TCP主机组列表</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/tcp/add/backend" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('name')) has-error @endif">
                    <label>名称：</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                <div class="form-group m-r-10">
                    <label>负载方式:</label>
                    <select class="form-control" name="type">
                        <option value="source">source</option>
                        <option value="roundrobin">roundrobin</option>
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
                    <th>负载方式</th>
                    <th>主机数</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->name}}}</td>
                        <td>{{{$v->type}}}</td>
                        <td>{{{$v->hosts->count()}}}</td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            [<a href="/admin/tcp/backend/detail?id={{{$v->id}}}">详情</a>]
                            [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/tcp/del/backend?id={{{$v->id}}}'">删除</a>]
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection