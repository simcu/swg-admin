@extends('admin.layout')
@section('content')
    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">添加网关代理</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="/admin/system/fast-add/gate">
                        <div class="form-group @if ($errors->has('gate_name')) has-error @endif">
                            <label class="col-md-3 control-label">显示名称</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="gate_name" value="{{old('gate_name')}}"
                                       placeholder="用于认证页面显示"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('gate_domain')) has-error @endif">
                            <label class="col-md-3 control-label">域名</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="gate_domain"
                                       value="{{old('gate_domain')}}"
                                       placeholder="xxx.bbb.cc"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('gate_schema')) has-error @endif">
                            <label class="col-md-3 control-label">后端协议</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="gate_schema" value="http"
                                           @if(old('gate_schema') != 'https') checked @endif/>
                                    HTTP
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gate_schema" value="https"
                                           @if(old('gate_schema') == 'https') checked @endif/>
                                    HTTPS
                                </label>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('gate_target')) has-error @endif">
                            <label class="col-md-3 control-label">后端地址</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="gate_target"
                                       placeholder="127.0.0.1:8080" value="{{old('gate_target')}}"/>
                            </div>
                        </div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-sm btn-success">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">添加TCP代理</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="/admin/system/fast-add/tcp">
                        <div class="form-group @if ($errors->has('tcp_ip')) has-error @endif">
                            <label class="col-md-3 control-label">监听IP</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tcp_ip" value="{{old('tcp_ip')}}"
                                       placeholder="0.0.0.0"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('tcp_port')) has-error @endif">
                            <label class="col-md-3 control-label">监听端口</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tcp_port" value="{{old('tcp_port')}}"
                                       placeholder="2233"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('tcp_target_ip')) has-error @endif">
                            <label class="col-md-3 control-label">后端IP</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tcp_target_ip"
                                       value="{{old('tcp_target_ip')}}"
                                       placeholder="127.0.0.1"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('tcp_target_port')) has-error @endif">
                            <label class="col-md-3 control-label">后端端口</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tcp_target_port"
                                       value="{{old('tcp_target_port')}}" placeholder="5233"/>
                            </div>
                        </div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-sm btn-success">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->
    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">添加HTTP代理</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="/admin/system/fast-add/http">
                        <div class="form-group @if ($errors->has('http_domain')) has-error @endif">
                            <label class="col-md-3 control-label">域名</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="http_domain"
                                       value="{{old('http_domain')}}"
                                       placeholder="xxx.bbb.cc"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('http_schema')) has-error @endif">
                            <label class="col-md-3 control-label">后端协议</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="http_schema" value="http"
                                           @if(old('http_schema') != 'https') checked @endif/>
                                    HTTP
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="http_schema" value="https"
                                           @if(old('http_schema') == 'https') checked @endif/>
                                    HTTPS
                                </label>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('http_target')) has-error @endif">
                            <label class="col-md-3 control-label">后端地址</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="http_target"
                                       placeholder="127.0.0.1:8080" value="{{old('http_target')}}"/>
                            </div>
                        </div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-sm btn-success">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
        <!-- begin col-6 -->
        <div class="col-md-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">添加HTTPS代理</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="/admin/system/fast-add/https">
                        <div class="form-group @if ($errors->has('https_domain')) has-error @endif">
                            <label class="col-md-3 control-label">域名</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="https_domain" value="{{old('https_domain')}}"
                                       placeholder="xx.bbb.cc"/>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('https_crt')) has-error @endif">
                            <label class="col-md-3 control-label">域名证书crt</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="https_crt" rows="3">{{old('https_crt')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('https_key')) has-error @endif">
                            <label class="col-md-3 control-label">域名证书key</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="https_key" rows="3">{{old('https_key')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('https_schema')) has-error @endif">
                            <label class="col-md-3 control-label">后端协议</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="https_schema" value="http"
                                           @if(old('https_schema') != 'https') checked @endif/>
                                    HTTP
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="https_schema" value="https"
                                           @if(old('https_schema') == 'https') checked @endif/>
                                    HTTPS
                                </label>
                            </div>
                        </div>
                        <div class="form-group @if ($errors->has('https_target')) has-error @endif">
                            <label class="col-md-3 control-label">后端地址</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="https_target"
                                       placeholder="127.0.0.1:8080" value="{{old('https_target')}}"/>
                            </div>
                        </div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-sm btn-success">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->

    </div>
    <!-- end row -->
@endsection