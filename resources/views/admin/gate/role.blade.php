@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">角色列表</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/gate/role/add" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('name')) has-error @endif">
                    <label>角色名称：</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5" style="float: right;">添加角色</button>
            </form>
        </div>
    </div>
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色名称</th>
                    <th>访问权限</th>
                    <th>用户列表</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->name}}}</td>
                        <td>
                            @if($v->id == 1)
                                拥有所有权限
                            @else
                                @forelse($v->acls as $acl)
                                    {{$acl->site->name}}
                                    @if(!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    -
                                @endforelse
                            @endif
                        </td>
                        <td>
                            @forelse($v->users as $user)
                                {{$user->username}}
                                @if(!$loop->last)
                                    ,
                                @endif
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            [<a href="/admin/gate/role/detail?id={{{$v->id}}}">详情</a>]
                            @unless($v->id == 1)
                                [
                                <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/gate/role/del?id={{{$v->id}}}'">删除</a>
                                ]
                            @endunless
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection