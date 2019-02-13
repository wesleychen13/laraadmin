@extends('admin.layouts.app')

@section('content')

    <?php
    if (!isset($data)) $data = array();
    if (!$data && session("data")) {
        $data = session("data");
    }
    if (!$data && session('_old_input')) {
        $data = session("_old_input");
    }
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>用户管理</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if(role('User/Info/index'))
                        <div class="row">
                            <div class="col-sm-10 pull-right">
                                <a href="{{ U('User/Info/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action=""
                                  class="form-horizontal form-validation" accept-charset="UTF-8" method="post">


                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">姓名</label>

                                    <div class="col-sm-9">
                                        <input id="data_username" name="data[username]" class="form-control"
                                               value="{{ $data['username'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">密码</label>

                                    <div class="col-sm-9">
                                        <input id="data_password" name="data[password]" class="form-control"
                                               value="{{ $data['password'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">EMAIL</label>

                                    <div class="col-sm-9">
                                        <input id="data_email" name="data[email]" email="true" class="form-control"
                                               value="{{ $data['email'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">手机号</label>

                                    <div class="col-sm-9">
                                        <input id="data_mobile" name="data[mobile]" isMobile="true" class="form-control"
                                               value="{{ $data['mobile'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">用户头像</label>

                                    <div class="col-sm-9">
                                        {!!  widget('Tools.ImgUpload')->single2('avatar','data[avatar]',isset($data['avatar'])? $data['avatar'] : "",'avatar') !!}
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">性别</label>

                                    <div class="col-sm-9">
                                            @foreach(dict()->get('global','sex') as $key=>$val)
                                                <label class="radio-inline">
                                                    <input type="radio" name="data[sex]" value="{{$key}}"
                                                           @if(isset($data['sex']) && $data['sex'] == $key)checked="checked" @endif/>{{$val}}
                                                </label>
                                            @endforeach
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">简介</label>

                                    <div class="col-sm-9">

                                        {!! editor('local') !!}
                                        <script id="container" name="content"
                                                type="text/plain">{{ $data['content'] or ''}}</script>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_referer"
                                               value="<?php echo urlencode(request()->server('HTTP_REFERER'));?>"/>
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                        <input type="submit" class="btn btn-success" style="margin-right:20px;">
                                        <input type="reset" class="btn btn-default">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- /.col-lg-10 -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>

@endsection