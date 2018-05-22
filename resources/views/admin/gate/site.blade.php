@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">网关站点列表</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/gate/site/add" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('name')) has-error @endif">
                    <label>名称：</label>
                    <input type="text" class="form-control ui-state-error" name="name"
                           value="{{old('name')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('domain')) has-error @endif">
                    <label>域名：</label>
                    <input type="text" class="form-control ui-state-error" name="domain"
                           value="{{old('domain')}}">
                </div>
                <div class="form-group m-r-10">
                    <label>主机组:</label>
                    <select class="form-control" name="upstream">
                        @foreach($hosts as $h)
                            <option value="{{$h->id}}">{{$h->schema}} - {{$h->name}}</option>
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
                    <th>域名</th>
                    <th>代理地址</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->name}}}</td>
                        <td>{{{$v->domain}}}</td>
                        <td>
                            <a href="/admin/upstream/detail?id={{$v->upstream_id}}"> {{{$v->upstream->schema}}}://{{{$v->upstream->name}}}</a>
                        </td>
                        <td>
                            <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/gate/site/del?id={{{$v->id}}}'">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection