@extends('admin.layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>角色列表</h5>
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
                                                <button type="submit" class="btn btn-primary"
                                                        style="height: 100%">搜索</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>

                                @if(role('Foundation/Role/create'))
                                    <div class="col-sm-8 pull-right">
                                        <a href="{{ U('Base/Role/create')}}"
                                           class="btn  btn-primary pull-right">添加</a>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr>
                                <th class="sorting" data-sort="id">ID</th>
                                <th class="sorting" data-sort="name">角色名</th>
                                <th>描述</th>
                                <th class="sorting" data-sort="level">角色等级</th>
                                <th class="sorting" data-sort="status">状态</th>
                                <th>相关操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($list))
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->mark }}</td>
                                        <td>{{ $item->level }}</td>
                                        <td>
                                            @if($item->status == 0)
                                                <span class="label label-danger">禁用</span>
                                            @else
                                                <span class="label label-primary">启用</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(role('Foundation/Role/update'))
                                                <button class="btn btn-sm btn-success"
                                                        onclick="window.location.href='{{ U('Base/Role/update')}}?id={{ $item->id }}' ">
                                                    修改
                                                </button>
                                            @endif

                                            @if(role('Foundation/Role/auth'))
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="window.location.href='{{ U('Base/Role/auth')}}?id={{ $item->id }}' ">
                                                    授权
                                                </button>
                                            @endif

                                            @if(role('Foundation/Role/status'))
                                                @if($item->status == 1)
                                                    <button class="btn btn-sm btn-warning"
                                                            onclick="window.location.href='{{ U('Base/Role/status')}}?id={{ $item->id }}&status=0' ">
                                                        禁用
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-warning"
                                                            onclick="window.location.href='{{ U('Base/Role/status')}}?id={{ $item->id }}&status=1' ">
                                                        启用
                                                    </button>

                                                @endif
                                            @endif

                                            @if(role('Foundation/Role/destroy'))
                                                <a class="btn btn-sm btn-danger"
                                                   href="{{ U('Base/Role/destroy')}}?id={{ $item->id }}"
                                                   onclick="return confirm('你确定执行删除操作？');">删除</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if(isset($list))
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" id="DataTables_Table_0_info"
                                         role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}
                                        条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dataTables_paginate paging_simple_numbers"
                                         id="DataTables_Table_0_paginate">
                                        {!! $list->setPath('')->appends(Request::all())->render() !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
