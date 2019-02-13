@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>字典管理</h5>
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
                            @if(role('Base/Dictionary/create'))
                                <div class="col-sm-8 pull-right">
                                    <a href="{{ U('Base/Dictionary/create')}}"
                                       class="btn btn-primary pull-right">添加</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                        <thead>
                        <tr>

                            <th class="sorting" data-sort="id"> ID</th>
                            <th class="sorting" data-sort="dictionary_table_code"> 数据字典表</th>
                            <th class="sorting" data-sort="dictionary_code"> 数据字典代码</th>
                            <th class="sorting" data-sort="key"> 程序中使用，数据库使用value</th>
                            <th class="sorting" data-sort="value"> 编码</th>
                            <th class="sorting" data-sort="name"> 名称</th>
                            <th width="22%">相关操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($list))
                            @foreach($list as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->dictionary_table_code }}</td>
                                    <td>{{ $item->dictionary_code }}</td>
                                    <td>{{ $item->key }}</td>
                                    <td>{{ $item->value }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if(role('Base/Dictionary/update'))
                                            <button onclick="window.location.href='{{ U('Base/Dictionary/update',['id'=>$item->id])}}'"
                                                    class="btn btn-success btn-sm">修改
                                            </button>
                                        @endif

                                        @if(role('Base/Dictionary/destroy'))
                                            <a class="btn btn-danger btn-sm"
                                               href="{{ U('Base/Dictionary/destroy',['id'=>$item->id])}}"
                                               onclick="return confirm('你确定执行删除操作？');">删除</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info"
                                 role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}
                                条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                {!! $list->setPath('')->appends(Request::all())->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection