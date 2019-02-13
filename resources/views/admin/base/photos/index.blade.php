@extends('admin.layouts.app')

@section('header')
    <style type="text/css">
        .side-class-bar ul li a {
            padding: 5px 10px !important;
        }

        .side-class-bar .a_selected {
            background-color: #eeeeee;
        }

        #file-upload-modal .modal-dialog {
            width: 80%;
        }

        #crop-file-modal .modal-dialog {
            width: 80%;
        }

        @media (min-width: 768px) {
            #file-upload-modal .modal-dialog {
                max-width: 1200px;
            }
        }

        .img-check {
            position: absolute;
            right: 5px;
            bottom: 5px;
            margin: 0;
            padding: 0;
            width: 22px;
            height: 22px;
            background: url(/base/img/check_blue_1.png) no-repeat;
            border: none;
            background-position: -144px 0;
        }

        .img-check.checked {
            background-position: -168px 0;
        }

        .img-card .content {
            text-align: center;
            word-wrap: break-word;
        }

        .img-card .image {
            position: relative;
        }

        .sg-divider {
            margin: 1rem 0rem;
            line-height: 1;
            height: 0em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(0, 0, 0, 0.85);
        }

        #add-class-modal-label {
            float: left
        }
    </style>
    <script type="text/javascript" src="/base/neditor-1.5.3/dialogs/image/image.js"></script>
    <script type="text/javascript" src="/base/neditor-1.5.3/dialogs/internal.js"></script>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                @if(isset($errors) && !$errors->isEmpty())
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">
                            &times;
                        </button>
                        @foreach($errors->keys() as $key)
                            {{ $errors->first($key) }}
                        @endforeach
                    </div>
                @endif
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="padding: 7px 14px 15px;">
                        <h5 style="margin-top: 8px">图片管理</h5>
                        <div class="ibox-tools" style="margin-top: 8px">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>

                        <div class="btn-group pull-right">
                            <div id="select-toogle" class="btn btn-sm btn-default">全选图片</div>
                            <div id="upload-btn" class="btn btn-sm btn-primary">上传</div>
                            <div id="add-class-btn" class="btn btn-sm btn-success">添加分类</div>
                            <div id="move-file" class="btn btn-sm btn-info">批量移动</div>
                            <div id="delete-file" class="btn btn-sm btn-warning">删除图片</div>
                            @if(Request::get('class') >1 )
                            <div id="delete-class" class="btn btn-sm btn-danger">删除分类</div>
                            @endif
                        </div>

                    </div>
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-sm-12">
                                <form method="GET" accept-charset="UTF-8">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" name="class" id="search-file-input"required>
                                                <option value="0" @if(!Request::get('class')) selected @endif>全部</option>
                                                @foreach($classes as $class)
                                                    <option value="{{$class->id}}"
                                                            @if($class->class == $a_class->class && Request::get('class')) selected @endif>{{$class->class}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3" id="data_1">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i></span>
                                                <input type="text" id="start" class="form-control" placeholder="开始日期" name="start"
                                                       value="{{Request::get('start') ? : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-3" id="data_2">
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i></span>
                                                <input type="text" id="end" class="form-control" placeholder="结束日期" name="end"
                                                       value="{{Request::get('end') ? : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    id="search-file">搜索
                                            </button>
                                        </div>

                                    </div>
                                </form>
                                <div class="photos"
                                     style="margin-top: 10px;padding-top: 15px;border-top: 1px solid #ddd">
                                    @foreach($photos as $photo)
                                        @if($loop->index % 6 == 0)
                                            <div class="row" style="padding: 0 10px">
                                                @endif
                                                <div class="img-card col-sm-2">
                                                    <div class="image">
                                                        <img src="{{ $photo->url }}" class="img-thumbnail">
                                                        <span class="img-check" data-id="{{ $photo->id }}"
                                                              data-name="{{ $photo->name }}"
                                                              data-src="{{ $photo->url }}"
                                                              data-class="{{ $photo->class }}"
                                                              data-md5="{{ $photo->md5 }}"></span>
                                                    </div>
                                                    <div class="content">
                                                        {{ $photo->name }}
                                                    </div>
                                                </div>
                                                @if($loop->index % 6 ==5)
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info"
                                 role="alert" aria-live="polite" aria-relevant="all">每页{{ $photos->count() }}
                                条，共{{ $photos->lastPage() }}页，总{{ $photos->total() }}条。
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                {!! $photos->setPath('')->appends(Request::all())->render() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- 添加分类 -->
    <div class="modal fade" id="add-class-modal" tabindex="-1" role="dialog" aria-labelledby="add-class-modal-label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="add-class-modal-label">添加分类</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" id="add-class-form"
                          action="{{ U('Base/AttachmentClass/add') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="class" class="col-md-2 col-md-offset-2 col-form-label">分类</label>
                            <div class="col-md-10">
                                <input id="class" type="text" class="form-control" name="class" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4" style="text-align: center">
                                <button type="submit" class="btn btn-primary  btn-lg" id="edit-project-confirm">
                                    确认添加
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 移动图片 -->
    <div class="modal fade" id="move-file-modal" tabindex="-1" role="dialog" aria-labelledby="move-file-modal-label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="move-file-modal-label">移动图片</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" id="move-file-form"
                          action="{{ U('Base/Photos/move') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="class" class="col-md-2 col-md-offset-2 control-label">移动到</label>
                            <div class="col-md-6">
                                <select class="form-control" name="class">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->class }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input class="ids" type="text" name="ids" style="display: none">
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4" style="text-align: center">
                                <button type="submit" class="btn btn-primary">
                                    确认
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 删除图片 -->
    <div class="modal fade" id="delete-file-modal" tabindex="-1" role="dialog"
         aria-labelledby="delete-file-modal-label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="delete-file-modal-label">确定要删除以下图片吗？</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="delete-files"></div>
                    <form class="form-horizontal" role="form" method="POST" id="delete-file-form"
                          action="{{ U('Base/Photos/delete') }}">
                        {{ csrf_field() }}
                        <input class="ids" type="text" name="ids" style="display: none">
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4" style="text-align: center">
                                <button type="submit" class="btn btn-primary">
                                    确认
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 删除分类 -->
    <div class="modal fade" id="delete-class-modal" tabindex="-1" role="dialog"
         aria-labelledby="delete-class-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="delete-class-modal-label">
                        {{ '确定要删除分类《' . $a_class->class . '》及其分类下所有的图片吗？' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST" id="delete-class-form"
                          action="{{ U('Base/AttachmentClass/delete', ['class' => $a_class->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4" style="text-align: center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    确认
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 上传图片 -->
    <div class="modal fade modal-margin-top" id="file-upload-modal" tabindex="-1" role="dialog"
         aria-labelledby="file-upload-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="delete-class-modal-label">
                        上传图片
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                   {!!  widget('Tools.ImgUpload')->upload('file_upload', 'file','default', ['position'=>'local','class' => $a_class->id]) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            $('#upload-btn').on('click', function () {
                $('#file-upload-modal').modal('show');
            });
            $('#add-class-btn').on('click', function () {
                $('#add-class-modal').modal('show');
            });

            $('#add-class-confirm-btn').on('click', function () {
                $('#add-class-form').submit();
            });

            $('.img-card', '.photos').on('click', function () {
                $(this).find('.img-check').toggleClass('checked');
            });

            $('#select-toogle').on('click', function () {
                if ($(this).hasClass('selected')) {
                    $('.photos .img-check').removeClass('checked');
                    $(this).removeClass('selected').text('全选图片');
                } else {
                    $('.photos .img-check').removeClass('checked').addClass('checked');
                    $(this).addClass('selected').text('取消全选');
                }
            });

            $('#move-file').on('click', function () {
                photos = $('.photos').find('.checked');
                if (photos.length != 0) {
                    ids = $(photos[0]).attr('data-id');
                    for (i = 1; i < photos.length; ++i) {
                        ids += ',' + $(photos[i]).attr('data-id');
                    }
                    $('.ids', '#move-file-modal').val(ids);
                    $('#move-file-modal').modal('show');
                }
            });

            $('#delete-file').on('click', function () {
                photos = $('.photos').find('.checked');
                info = '';
                if (photos.length != 0) {
                    ids = $(photos[0]).attr('data-id');
                    info += $(photos[0]).attr('data-name');
                    for (i = 1; i < photos.length; ++i) {
                        ids += ',' + $(photos[i]).attr('data-id');
                        info += '<br>' + $(photos[i]).attr('data-name');
                    }
                    $('.ids', '#delete-file-modal').val(ids);
                    $('#delete-files').html(info);
                    $('#delete-file-modal').modal('show');
                }
            });

            $('#delete-class').on('click', function () {
                $('#delete-class-modal').modal('show');
            });

            $('#search-file').on('click', function (e) {
                e.preventDefault();
                $input = $('#search-file-input');
                $start = $('#start');
                $end = $('#end');
                $url = "{{ U('Base/Photos/index') }}" + '?class=' + $input.val().trim();

                if($start.val()){
                    $url =$url + '&start=' + $start.val()
                }
                if($end.val()){
                    $url =$url + '&end=' + $end.val();
                }
                window.location = $url;
            });

        });
    </script>
@endsection