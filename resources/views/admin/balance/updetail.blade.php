@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">Web主机组详情 - {{$detail->name}} [{{$detail->type}}]</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0)style="display: none;" @endif>
            <form class="form-inline" action="/admin/upstream/add/host" method="POST">
                <div class="form-group m-r-10 @if ($errors->has('ip')) has-error @endif">
                    <label>主机地址:</label>
                    <input type="text" class="form-control ui-state-error" name="ip" placeholder="123.123.123.123"
                           value="{{old('ip')}}">
                </div>
                <div class="form-group m-r-5 @if ($errors->has('port')) has-error @endif">
                    <label>主机端口:</label>
                    <input type="text" class="form-control ui-state-error" name="port" placeholder="8080"
                           value="{{old('port')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('weight')) has-error @endif">
                    <label>主机权重:</label>
                    <input type="text" class="form-control ui-state-error" name="weight" value="10"
                           value="{{old('weight')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('max_fails')) has-error @endif">
                    <label>失败次数:</label>
                    <input type="text" class="form-control ui-state-error" name="max_fails" value="3"
                           value="{{old('max_fails')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('fail_timeout')) has-error @endif">
                    <label>失败超时:</label>
                    <input type="text" class="form-control ui-state-error" name="fail_timeout" value="120"
                           value="{{old('fail_timeout')}}">
                </div>
                <div class="form-group m-r-10">
                    <label>是否备用:</label>
                    <select class="form-control" name="backup">
                        <option value="0">否 - 正常参与负载均衡</option>
                        <option value="1">是 - 其他主机失效时生效</option>
                    </select>
                </div>
                <input type="hidden" name="upid" value="{{$detail->id}}">
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
                    <th>IP</th>
                    <th>端口</th>
                    <th>权重</th>
                    <th>失败次数</th>
                    <th>失败超时</th>
                    <th>备用</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->ip}}}</td>
                        <td>{{{$v->port}}}</td>
                        <td>{{$v->weight}}</td>
                        <td>{{$v->max_fails}}</td>
                        <td>{{$v->fail_timeout}}</td>
                        <td>{{$v->backup?'是':'否'}}</td>
                        <td>
                            [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/upstream/del/host?id={{{$v->id}}}'">删除</a>]
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection