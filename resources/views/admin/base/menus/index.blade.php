@extends('admin.layouts.app')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>菜单管理</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <form method="GET" action="" accept-charset="UTF-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{Request::get('keyword')}}"
                                                   placeholder="请输入关键词"
                                                   name="keyword">
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-primary" style="height: 100%">搜索</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                @if(role('Foundation/Menus/create'))
                                    <div class="col-sm-8 pull-right">
                                        <a href="{{ U('Base/Menus/create')}}"
                                           class="btn btn-primary pull-right">添加</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>URl</th>
                                <th>是否显示</th>
                                <th>排序</th>
                                <th>相关操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $val)
                                <tr>
                                    <td>{{ $val['spacer'] }}{{ $val['name'] }}</td>
                                    <td>{{ $val['path'] }}</td>

                                    <td>
                                        @if($val['display'] == 0)
                                            <span class="label label-default">隐藏</span>
                                        @else
                                            <span class="label label-success">显示</span>
                                        @endif
                                    </td>
                                    <td>{{ $val['sort'] }}</td>
                                    <td>
                                        @if(role('Foundation/Menus/create'))
                                            <button onclick="window.location.href='{{ U('Base/Menus/create',['pid'=>$val['id']])}}'"
                                                    class="btn btn-primary btn-sm">添加子菜单
                                            </button>
                                        @endif

                                        @if(role('Foundation/Menus/update'))
                                            <button onclick="window.location.href='{{ U('Base/Menus/update',['id'=>$val['id']])}}'"
                                                    class="btn btn-warning btn-sm">修改
                                            </button>
                                        @endif

                                        @if(role('Foundation/Menus/destroy'))
                                            <a class="btn btn-danger btn-sm"
                                               href="{{ U('Base/Menus/destroy',['id'=>$val['id']])}}"
                                               onclick="return confirm('你确定执行删除操作？');">删除</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
