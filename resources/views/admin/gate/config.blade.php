@extends('admin.layout')

@section('content')
    <div class="panel-body">
        <form method="POST">
            <fieldset>
                <div class="form-group">
                    <label>Token请求地址</label>
                    <input type="text" class="form-control" name="config_token_url"
                           value="{{\Illuminate\Support\Facades\Redis::get('swg_gate_url')?:'http://'.$_SERVER['HTTP_HOST'].'/'}}">
                </div>
                <div class="form-group">
                    <label>Token过期时间</label>
                    <input type="text" class="form-control" name="config_token_expire"
                           value="{{\Illuminate\Support\Facades\Redis::get('swg_gate_expire')?:600}}">
                </div>
                <div class="form-group">
                    <label>Token时效模式</label>
                    <select class="form-control input-sm" name="config_token_mode">
                        <option value="1"
                                @if(\Illuminate\Support\Facades\Redis::get('swg_gate_mode') == 1) selected @endif>自动延续
                            -
                            每次请求会刷新Token有效期
                        </option>
                        <option value="2"
                                @if(\Illuminate\Support\Facades\Redis::get('swg_gate_mode') == 2) selected @endif>固定时间
                            -
                            Token使用固定有效期，到期时效
                        </option>
                    </select>
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-sm btn-primary m-r-5">保存配置</button>
            </fieldset>
        </form>
    </div>
@endsection