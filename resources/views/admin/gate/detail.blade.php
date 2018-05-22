@extends('admin.layout')

@section('content')
    <legend>角色详情 - {{$role->name}} ：</legend>
    @unless($role->id == 1)
        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-heading">
                <h4 class="panel-title">权限</h4>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>域名</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($role->acls as $v)
                        <tr>
                            <td>{{{$v->site->id}}}</td>
                            <td>{{{$v->site->name}}}</td>
                            <td>{{{$v->site->domain}}}</td>
                            <td>
                                <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/gate/role/del/site?rid={{{$role->id}}}&hid={{{$v->site->id}}}'">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <form method="POST" action="/admin/gate/role/add/site">
                    <div class="form-group">
                        <div class="col-md-10">
                            <select class="form-control" name="hid">
                                <option value="" selected="">选择要添加的站点</option>
                                @foreach($hosts as $lh)
                                    <option value="{{{$lh->id}}}">{{{$lh->name}}} - {{{$lh->domain}}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{{csrf_field()}}}
                        <input type="hidden" name="rid" value="{{{$role->id}}}">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endunless

    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-heading">
            <h4 class="panel-title">用户</h4>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>用户名称</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($role->users as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->username}}}</td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/gate/role/del/user?rid={{{$role->id}}}&uid={{{$v->id}}}'">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <form method="POST" action="/admin/gate/role/add/user">
                <div class="form-group">
                    <div class="col-md-10">
                        <select class="form-control" name="uid">
                            <option value="" selected="">选择要添加的用户</option>
                            @foreach($users as $lu)
                                <option value="{{{$lu->id}}}">{{{$lu->username}}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{{csrf_field()}}}
                    <input type="hidden" name="rid" value="{{{$role->id}}}">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary m-r-5">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(count($errors) > 0)
        <script>
            alert('操作失败，请重试')
        </script>
    @endif
@endsection