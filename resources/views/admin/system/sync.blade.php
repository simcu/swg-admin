@extends('admin.layout')

@section('content')
    <div class="panel panel-inverse" data-sortable-id="table-basic-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:if(confirm('确实要删除吗?'))location='/admin/system/sync?doit=1'"
                   class="btn btn-xs btn-icon btn-circle btn-warning"><i
                            class="fa fa-plus"></i></a>
            </div>
            <h4 class="panel-title">配置预览信息如下,点击右边同步:</h4>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($config as $k => $v)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{{$k}}}</td>
                        <td>{!! str_replace("\n","<br/>",str_replace(" ","&nbsp;&nbsp;",$v)) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection