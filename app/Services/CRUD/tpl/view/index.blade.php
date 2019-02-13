@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{desc}}</h5>
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

                            @if(role('{{path}}/create'))
                                <div class="col-sm-8 pull-right">
                                    <a href="{{ U('{{path}}/create')}}" class="btn btn-primary pull-right">添加</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                        <thead>
                        <tr>
                            {{listThStr}}
                            <th width="22%">相关操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($list))
                            @foreach($list as $key => $item)
                                <tr>
                                    {{listTdStr}}
                                    <td>
                                        @if(role('{{path}}/update'))
                                            <button class="btn btn-sm btn-success"
                                                    onclick="window.location.href='{{ U('{{path}}/update',['id'=>$item->id])}}' ">
                                                修改
                                            </button>

                                        @endif

                                        @if(role('{{path}}/destroy'))
                                            <a class="btn btn-sm btn-danger"
                                               href="{{ U('{{path}}/destroy',['id'=>$item->id])}}"
                                               onclick="return confirm('你确定执行删除操作？');">删除</a>
                                        @endif

                                        @if(role('{{path}}/view'))
                                            <button onclick="layer.open({type: 2,area: ['80%', '90%'],content: '{{ U('{{path}}/view',['{{primaryKey}}'=>$item->{{primaryKey}}])}}'});"
                                                    class="btn btn-sm btn-primary ">查看
                                            </button>
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