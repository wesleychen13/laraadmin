@extends('admin.layouts.app')

@section('header')
    <style type="text/css">
        .icons-box .infont{width: 20%;float: left;height: 82px;overflow: hidden}
    </style>
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo isset($data['id']) ? '编辑' : '添加'; ?>菜单</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
                    @if(role('Foundation/Menus/index'))
				    <div class="row">
    					<div class="col-sm-10 pull-right">
    					   <a href="{{ U('Base/Menus/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
                    @endif

                    <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">
        
                               <div class="form-group row">
                                    <label class="col-form-label col-sm-3">所属关系</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="data[pid]">
                                            <option value="0">顶级</option>
                                            @foreach($MenusTrees AS $val)
                                            <option value={{ $val['id'] }} @if((isset($data['pid']) && $data['pid']==$val['id']) || Request::get('pid')==$val['id']) selected @endif>{{ $val['spacer'] }}{{ $val['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">URL</label>
                                    <div class="col-sm-9">
                                        <input name="data[path]" class="form-control" id="data_module"  required="" aria-required="true"  value="{{ $data['path'] or ''}}" placeholder="URL路径">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">图标</label>
                                    <div class="col-sm-9">
                                        <input name="data[ico]" class="form-control" id="data_ico"   onclick="showicon()" value="{{ $data['ico'] or 'fa-bar-chart-o'}}" placeholder="图标 如：fa-bar-chart-o">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">菜单名</label>
                                    <div class="col-sm-9">
                                        <input name="data[name]" class="form-control" id="data_name" required="" aria-required="true" value="{{ $data['name'] or ''}}" placeholder="菜单名">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">是否显示</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="data[display]" value="0" <?php if(isset($data['display']) && $data['display'] == 0){ echo ' checked="checked"'; } ?>>否
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="data[display]" value="1" <?php if(isset($data['display']) && $data['display'] == 1){ echo ' checked="checked"'; } ?>>是
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">排序</label>
                                    <div class="col-sm-9">
                                        <input name="data[sort]" class="form-control" value="{{ $data['sort'] or ''}}" placeholder="排序">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_referer" value="<?php echo urlencode($_SERVER['HTTP_REFERER']);?>"/>
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                        <input type="submit" class="btn btn-success" style="margin-right:20px;">
                                        <input type="reset" class="btn btn-default" >
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
</div>

<div id="functions" style="display: none;">
    @include('admin.layouts.icon')
</div>

@endsection

@section('js')
    <script>

        function showicon(){
            layer.open({
                type: 1,
                title:'点击选择图标',
                area: ['800px', '80%'], //宽高
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                content: $('#functions')
            });
        }

        $('.infont').find('a').click(function(){
            var str=$(this).text();
            $('#data_ico').val( $.trim(str));
            layer.closeAll();
        })
    </script>
@endsection