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
                    <h5>字典管理</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if(role('Base/Dictionary/index'))
                        <div class="row">
                            <div class="col-sm-10 pull-right">
                                <a href="{{ U('Base/Dictionary/index')}}"
                                   class="btn btn-sm btn-primary pull-right">返回列表</a>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action=""
                                  class="form-horizontal form-validation" accept-charset="UTF-8" method="post">


                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">数据字典表</label>

                                    <div class="col-sm-9">
                                        <input id="data_dictionary_table_code" name="data[dictionary_table_code]"
                                               class="form-control" value="{{ $data['dictionary_table_code'] or ''}}"
                                               required="" aria-required="true" placeholder="">
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">数据字典代码</label>

                                    <div class="col-sm-9">
                                        <input id="data_dictionary_code" name="data[dictionary_code]"
                                               class="form-control" value="{{ $data['dictionary_code'] or ''}}"
                                               required="" aria-required="true" placeholder="">
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">程序中使用，数据库使用value</label>

                                    <div class="col-sm-9">
                                        <input id="data_key" name="data[key]" class="form-control"
                                               value="{{ $data['key'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">编码</label>

                                    <div class="col-sm-9">
                                        <input id="data_value" name="data[value]" class="form-control"
                                               value="{{ $data['value'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">名称</label>

                                    <div class="col-sm-9">
                                        <input id="data_name" name="data[name]" class="form-control"
                                               value="{{ $data['name'] or ''}}" required="" aria-required="true"
                                               placeholder="">
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-form-label col-sm-3">排序</label>

                                    <div class="col-sm-9">
                                        <input id="data_sort" name="data[sort]" class="form-control"
                                               value="{{ $data['sort'] or ''}}" required="" aria-required="true"
                                               placeholder="">
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