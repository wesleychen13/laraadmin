@extends('admin.layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>用户列表</h5>
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
                                @if(role('Foundation/User/create'))
                                    <div class="col-sm-8 pull-right">
                                        <a href="{{ U('Base/User/create')}}"
                                           class="btn btn-primary pull-right">添加</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr>
                                <th class="sorting" data-sort="name">账号</th>
                                <th class="sorting" data-sort="real_name">姓名</th>
                                <th class="sorting" data-sort="email">邮箱</th>
                                <th class="sorting" data-sort="mobile">电话</th>
                                <th class="sorting" data-sort="admin_role_id">角色</th>
                                <th>相关操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($list))
                                @foreach($list as $item)
                                    <tr>
                                        <td>{{ $item->username or '' }}</td>
                                        <td>{{ $item->real_name or '' }}</td>
                                        <td>{{ $item->email or '' }}</td>
                                        <td>{{ $item->mobile or '' }}</td>
                                        <td>
                                            <?php
                                            if ($item->admin_role_id) {
                                                $role_arr = explode(',', $item->admin_role_id);
                                                foreach ($role_arr AS $key => $role) {
                                                    if (isset($roles[$role])) {
                                                        echo $key == 0 ? $roles[$role] : '，' . $roles[$role];
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if(role('Foundation/User/update'))
                                                    <button class="btn btn-sm btn-success"
                                                            onclick="window.location.href='{{ U('Base/User/update')}}?id={{ $item->id }}' ">
                                                        修改
                                                    </button>
                                                @endif
                                            </div>
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
