@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">用户列表</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/system/user/add" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('username')) has-error @endif">
                    <label>用户名称：</label>
                    <input type="text" class="form-control ui-state-error" name="username"
                           value="{{old('username')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('password')) has-error @endif">
                    <label>登录密码：</label>
                    <input type="text" class="form-control" name="password" value="{{old('password') ?: 'love1314'}}">
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5" style="float: right;">添加新用户</button>
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
                    <th>角色</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->username}}}</td>
                        <td>
                            @forelse($v->roles as $role)
                                <a href="/admin/gate/role/detail?id={{{$role->id}}}">{{$role->name}}</a>
                                @if(!$loop->last)
                                    ,
                                @endif
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{$v->created_at or '-'}}</td>
                        <td>
                            @if($v->id != session('logined.user')->id)
                                <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/system/user/del?id={{{$v->id}}}'">删除</a>
                            @else
                                删除
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection