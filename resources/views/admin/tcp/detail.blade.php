@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">Tcp主机组详情 - {{$detail->name}} [{{$detail->type}}]</h4>
        </div>
        <div class="panel-body" @if (!$errors->count()>0)style="display: none;" @endif>
            <form class="form-inline" action="/admin/tcp/backend/add/detail" method="POST">
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
                <div class="form-group m-r-10">
                    <label>健康检查:</label>
                    <select class="form-control" name="check">
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="form-group m-r-10 @if ($errors->has('inter')) has-error @endif">
                    <label>检查间隔(ms):</label>
                    <input type="text" class="form-control ui-state-error" name="inter" value="3000"
                           value="{{old('inter')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('rise')) has-error @endif">
                    <label>复活次数:</label>
                    <input type="text" class="form-control ui-state-error" name="rise" value="3"
                           value="{{old('rise')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('fall')) has-error @endif">
                    <label>下线次数:</label>
                    <input type="text" class="form-control ui-state-error" name="fall" value="3"
                           value="{{old('fall')}}">
                </div>
                <div class="form-group m-r-10 @if ($errors->has('weight')) has-error @endif">
                    <label>主机权重:</label>
                    <input type="text" class="form-control ui-state-error" name="weight" value="10"
                           value="{{old('weight')}}">
                </div>
                <input type="hidden" name="bid" value="{{$detail->id}}">
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
                    <th>健康检查</th>
                    <th>检查间隔</th>
                    <th>复活次数</th>
                    <th>下线次数</th>
                    <th>权重</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $v)
                    <tr>
                        <td>{{{$v->id}}}</td>
                        <td>{{{$v->ip}}}</td>
                        <td>{{{$v->port}}}</td>
                        <td>{{{$v->check?"是":"否"}}}</td>
                        <td>{{{$v->check?$v->inter:'-'}}}</td>
                        <td>{{$v->check?$v->rise:'-'}}</td>
                        <td>{{$v->check?$v->fall:'-'}}</td>
                        <td>{{$detail->type=="source"?"-":$v->weight}}</td>
                        <td>
                            [<a href="javascript:if(confirm('确实要删除吗?'))location='/admin/tcp/backend/del/detail?id={{{$v->id}}}'">删除</a>]
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection