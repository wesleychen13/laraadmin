<?php
/**
 * 图片上传
 */


namespace App\Widget\Tools;

use App\Models\CmsLinkModel;

class ImgUpload
{

    /**
     * 统一上传
     * @param $text         按钮文字
     * @param $folder       上传文件夹
     * @param $id           id
     * @param $option       附加选项
     */
    public function upload($id, $name, $folder = '', $option = [])
    {
        $position = isset($option['position']) ? $option['position'] : 'local';
        $maxFileSize = isset($option['maxSize']) ? $option['maxSize'] : 10 * 1024;
        $class = isset($option['class']) ? $option['class'] : 1;

        $html = <<<EOF
                    <div class="file-loading">
                        <input id="$id" name="file[]" type="file" multiple>
                    </div>
                    <script>
                        $('#$id').fileinput({
                            showPreview: true,
                            showClose: false,
                            theme: 'fa',
                            language: 'zh',
                            uploadUrl: "/admin/Base/AttachmentInfo/upload",
                            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                            enctype: 'multipart/form-data',
                            maxFileSize: $maxFileSize,
                            uploadExtraData:{'folder':'$folder','position':'$position','class':'$class'},
                        });
                        
                        $('#$id').on("fileuploaded", function (event, data, previewId, index) {
                                setTimeout(function() {
                                  window.location.reload()
                                },2000)
                        })
                    </script>
EOF;
        return $html;
    }

    /**
     * 单个图片上传
     * @param $folder
     * @param string $position
     * @param array $option
     */
    public function single($id, $name = "data[image]", $file = '')
    {
        $url = U("/Base/Photos/index");
        $imgHtml = "";
        if (!empty($file)) {
            $imgHtml .= "<div class='file-preview-frame krajee-default kv-preview-thumb file-preview-success'>
                                <div class='kv-file-content'>
                                    <img  src=\"{$file}\" style='width:100%;'/> 
                                    
                                    <input type='hidden' name=\"{$name}\" value=\"{$file}\">
                                </div>
                                <div class='file-thumbnail-footer'>
                                    <div class='file-footer-caption'> 
                                        <div class='file-caption-info'></div>
                                        <div class='file-size-info'></div>
                                </div>
                                
                                <div class='file-actions'>
                                    <div class='file-footer-buttons'>
                                         <button type='button' onclick='$(this).parent().parent().parent().parent().remove()' class='kv-file-remove btn btn-sm btn-kv btn-default btn-outline-secondary' title='删除文件'><i class='glyphicon glyphicon-trash'></i></button>
                                    </div>
                                </div>
                                </div>
                                </div>";

        }

        $idbutton = $id . '_button';
        $html = <<<EOF
                            <div style="clear:both">
                            <div id="$id" class="file-preview">
                            <div class="file-preview-thumbnails">
                                    $imgHtml
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            <button class="btn btn-primary"  id="$idbutton" type="button">选择图片</button>

                             </div>
                            <script type="text/javascript">
                                $("#$idbutton").click(function() {
                                    layer.open({
                                        type: 2,
                                        title: '选择图片',
                                        shadeClose: true,
                                        shade: 0.8,
                                        area: ['80%', '90%'],
                                        content: '$url',
                                        btn: ['确定'],
                                        yes:function(index, layero){
                                            var body = layer.getChildFrame('body',index);//建立父子联系
                                            var imglist = body.find('div.img-card span.checked');
                                            if(imglist.length > 1){
                                                layer.alert('只能选择单张图片')
                                            }else {
                                            $.each(imglist,function(i) {
                                               $("#$id .file-preview-thumbnails").html("<div class='file-preview-frame krajee-default kv-preview-thumb file-preview-success'><div class='kv-file-content'><img  src=" + $(this).attr('data-src') + " style='width:100%' /> <input type='hidden' name='{$name}' value="+ $(this).attr('data-src')+"></div><div class='file-thumbnail-footer'><div class='file-footer-caption'> <div class='file-caption-info'></div><div class='file-size-info'></div></div><div class='file-actions'><div class='file-footer-buttons'><button type='button' class='kv-file-remove btn btn-sm btn-kv btn-default btn-outline-secondary' onclick='$(this).parent().parent().parent().parent().remove()' title='删除文件'><i class='glyphicon glyphicon-trash'></i></button></div></div></div></div>"); 
                                            })
                                            layer.close(index);   
                                          }  
                                         
                                        }                         
                                    });
                                });
                                
                            </script>

EOF;
        return $html;

    }

    public function single2($id, $name = "data[image]", $file = "", $folder, $option = [])
    {
        $folder = urlencode($folder);
        $position = isset($option['position']) ? $option['position'] : 'local';
        $option['width'] = isset($option['width']) ? $option['width'] : "";
        $option['height'] = isset($option['height']) ? $option['height'] : "";
        $maxFileSize = isset($option['maxSize']) ? $option['maxSize'] : 10 * 1024;

        $filename = explode('/', $file);
        $filename = end($filename);
        $class = isset($option['class']) ? $option['class'] : 1;
        $token = csrf_token();

        $html = <<<EOF
             <div class="form-group">
            <div class="file-loading">
                <input id="$id" type="file" name="file">
            </div>
            <input class="$id" type="hidden" name="$name" value="$file">
        </div>
 
   
        <script>
        $("#$id").fileinput({
        language: 'zh',
        showUpload: false,
        showCaption: false,
        showClose:false,
        showRemove:false,
        uploadAsync:true,
        dropZoneEnabled: false,
        uploadUrl: "/admin/Base/AttachmentInfo/upload",
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
        enctype: 'multipart/form-data',
        maxFileSize: $maxFileSize,
                           
        overwriteInitial: true,
        initialPreviewAsData: true,
        initialPreview: [
            "$file",
        ],
        initialPreviewConfig: [
            {caption: "$filename", url: "/admin/Base/AttachmentInfo/remove?file=$file"},
        ],
        
        uploadExtraData:{'folder':'$folder','position':'$position','class':'$class'},
        deleteExtraData:{'_token': '$token'},

    }).on("filebatchselected", function(event, files) {
            $(this).fileinput("upload");
        })
        .on("fileuploaded", function(event, data) {
            if(data.response)
            {
                if($('.$id').length){
                    $('.$id').val(data.response.fileurl)
                }else{
                     $("img[src='"+ data.reader.result +"']").after("<input class='$id' type=\"hidden\" name=\"{$name}\" value=\" "+data.response.fileurl + " \" />")
                }
                
            }
        })
        .on("filesuccessremove",function(event,id) {
          url = $('#'+ id + ' input').val();
          $.post("/admin/Base/AttachmentInfo/remove", { file: url, _token: "$token" } );
        })
        .on("filedeleted",function(event,key,xhr,data) {
           url = xhr.responseJSON.data
           $("input[value='"+ url +"']").remove()
    });
</script>

EOF;
        return $html;
    }

    /**
     * 统一多张图片
     * @param $folder
     * @param $id
     * @param string $name
     * @param array $imgs
     * @param null $callBackFun
     * @return string
     */
    public function multi($id, $name = "data[image]", $files = [], $option = [])
    {
        $url = U("/Base/Photos/index");
        $maxCount = isset($option['maxCount']) ? $option['maxCount'] : 0;

        $name = $name . '[]';
        $imgHtml = "";
        if (!empty($files)) {
            foreach ($files as $file) {
                $imgHtml .= "<div class='file-preview-frame krajee-default kv-preview-thumb file-preview-success'>
                                <div class='kv-file-content'>
                                    <img  src=\"{$file}\" style='width:100%;'/> 
                                    
                                    <input type='hidden' class='$id' name=\"{$name}\" value=\"{$file}\">
                                </div>
                                <div class='file-thumbnail-footer'>
                                    <div class='file-footer-caption'> 
                                        <div class='file-caption-info'></div>
                                        <div class='file-size-info'></div>
                                </div>
                                
                                <div class='file-actions'>
                                    <div class='file-footer-buttons'>
                                         <button type='button' onclick='$(this).parent().parent().parent().parent().remove()' class='kv-file-remove btn btn-sm btn-kv btn-default btn-outline-secondary' title='删除文件'><i class='glyphicon glyphicon-trash'></i></button>
                                    </div>
                                </div>
                                </div>
                                </div>";
            }
        }

        $idbutton = $id . '_button';
        $html = <<<EOF
                            <div style="clear:both">
                            <div id="$id" class="file-preview">
                            <div class="file-preview-thumbnails">
                                    $imgHtml
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            <button class="btn btn-primary"  id="$idbutton" type="button">选择图片</button>

                             </div>
                            <script type="text/javascript">
                           
                                $("#$idbutton").click(function() {
                                      max = '$maxCount'
                                      current_num = $('.$id').length;
       
                                    if(max > 0 && max != current_num){
                                            max = max - current_num
                                    }
                                    console.log(current_num)
                                    layer.open({
                                        type: 2,
                                        title: '选择图片',
                                        shadeClose: true,
                                        shade: 0.8,
                                        area: ['80%', '90%'],
                                        content: '$url',
                                        btn: ['确定'],
                                        yes:function(index, layero){
                                            var body = layer.getChildFrame('body',index);//建立父子联系
                                            var imglist = body.find('div.img-card span.checked');
                                            if(imglist.length > max){
                                                layer.alert('只能选择'+max+'张图片')
                                            }else{
                                                $.each(imglist,function(i) {
                                               $("#$id .file-preview-thumbnails").append("<div class='file-preview-frame krajee-default kv-preview-thumb file-preview-success'><div class='kv-file-content'><img  src=" + $(this).attr('data-src') + " style='width:100%' /> <input class='$id' type='hidden' name='{$name}' value="+ $(this).attr('data-src')+"></div><div class='file-thumbnail-footer'><div class='file-footer-caption'> <div class='file-caption-info'></div><div class='file-size-info'></div></div><div class='file-actions'><div class='file-footer-buttons'><button type='button' class='kv-file-remove btn btn-sm btn-kv btn-default btn-outline-secondary' onclick='$(this).parent().parent().parent().parent().remove()' title='删除文件'><i class='glyphicon glyphicon-trash'></i></button></div></div></div></div>"); 
                                            })
                                           } 
                                            
                                            
                                         layer.close(index);   
                                        }                         
                                    });
                                });
                                
                            </script>

EOF;
        return $html;

    }

    public function multi2($id, $name = "image", $files = "", $folder, $option = [])
    {
        $folder = urlencode($folder);
        $position = isset($option['position']) ? $option['position'] : 'local';
        $option['width'] = isset($option['width']) ? $option['width'] : "";
        $option['height'] = isset($option['height']) ? $option['height'] : "";
        $maxFileSize = isset($option['maxSize']) ? $option['maxSize'] : 10 * 1024;
        $maxCount = isset($option['maxCount']) ? $option['maxCount'] : 0;

        $class = isset($option['class']) ? $option['class'] : 1;

        $imgHtml = "";
        $preview = json_encode($files);
        $caps = [];
        foreach ($files as $k => $file) {
            $caps[$k]['caption'] = $file;
            $caps[$k]['url'] = "/admin/Base/AttachmentInfo/remove?file=" . $file;
        }
        $caps = json_encode($caps);
        $token = csrf_token();

        foreach ($files as $file) {
            $imgHtml .= "<input class='$id' type=\"hidden\" name=\"{$name}[]\" value=\"{$file}\" />";
        }

        $html = <<<EOF
             <div class="form-group">
            <div class="file-loading">
                <input id="$id" type="file" name="file[]" multiple>
            </div>
            $imgHtml
        </div>
    <link href="/base/plugins/bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="/base/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/base/plugins/bootstrap-fileinput/js/locales/zh.js" type="text/javascript"></script>
   
        <script>
        var max = '$maxCount';
        var c_num = $('.$id').length;
        if(max != 0 && max != c_num){
            max = max - c_num
        }

        $("#$id").fileinput({
        language: 'zh',
        showUpload: false,
        showCaption: false,
        showClose:false,
         showRemove:false,
        uploadAsync:true,
        dropZoneEnabled: false,
        showZoom:false,
        uploadUrl: "/admin/Base/AttachmentInfo/upload",
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
        enctype: 'multipart/form-data',
        maxFileSize: $maxFileSize,
        maxFileCount: 0, 
        overwriteInitial: false,  
        initialPreviewAsData: true,
        initialPreview: $preview,
        initialPreviewConfig: $caps,
        uploadExtraData:{'folder':'$folder','position':'$position','class':'$class'},
        deleteExtraData:{'_token': '$token'},

    }).on("filebatchselected", function(event, files) {
         c_num = $('.$id').length;
         up_num = files.length
         if(max < Number(c_num) + Number(up_num)){
             layer.alert('最多只能上传' + max + '张图片')
         }else {
              $(this).fileinput("upload");
         }
        })
        .on("fileuploaded", function(event, data,extra,d) {
       
            if(data.response.code && data.response.code == 200)
            {
                  $("img[src='"+ data.reader.result +"']").after("<input class='$id' type=\"hidden\" name=\"{$name}[]\" value=\" "+data.response.fileurl + " \" />")
            }
        })
       .on("filesuccessremove",function(event,id) {
          url = $('#'+ id + ' input').val();
          $.post("/admin/Base/AttachmentInfo/remove", { file: url, _token: "$token" } );
        })
        
        .on("filedeleted",function(event,key,xhr,data) {
           url = xhr.responseJSON.data
           $("input[value='"+ url +"']").remove()
    });
</script>

EOF;
        return $html;
    }

}