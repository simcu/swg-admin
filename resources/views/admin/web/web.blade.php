@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">站点管理</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0) style="display: none;" @endif>
            <form class="form-inline" action="/admin/web/add" method="POST">
                <div class="form-group m-r-10">
                    <label>证书:</label>
                    <select class="form-control" name="ssl">
                        <option value="0">HTTP服务</option>
                        @foreach($ssls as $h)
                            <option value="{{$h->id}}">HTTPS - {{$h->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-r-10 @if ($errors->has('domain')) has-error @endif">
                    <label>域名：</label>
                    <input type="text" class="form-control ui-state-error" name="domain"
                           value="{{old('domain')}}">
                </div>
                <div class="form-group m-r-10">
                    <label>跳转:</label>
                    <select class="form-control" name="force">
                        <option value="0">http不配置</option>
                        <option value="1">http跳转https</option>
                    </select>
                </div>
                <div class="form-group m-r-10">
                    <label>主机组:</label>
                    <select class="form-control" name="upstream">
                        @foreach($hosts as $h)
                            <option value="{{$h->id}}">{{$h->schema}}://{{$h->name}}</option>
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
                    <th>协议</th>
                    <th>域名</th>
                    <th>证书</th>
                    <th>强制HTTPS</th>
                    <th>主机组</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->schema}}}</td>
                        <td>{{{$v->domain}}}</td>
                        <td>@if($v->schema == 'https'){{{$v->ssl->name}}} @else - @endif</td>
                        <td>@if($v->schema == 'https'){{{$v->force_https?'是':'否'}}} @else - @endif</td>
                        <td><a href="/admin/upstream/detail?id={{$v->upstream->id}}">{{{$v->upstream->schema}}}://{{{$v->upstream->name}}}</a></td>
                        <td>{{{$v->created_at}}}</td>
                        <td>
                            [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/web/del?id={{{$v->id}}}'">删除</a>]
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection