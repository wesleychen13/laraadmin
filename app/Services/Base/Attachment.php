<?php
namespace App\Services\Base;

use App\Models\AttachmentInfoModel;
use App\Services\OSS;
use Response;
use App\Models\BaseSettingsModel;
use Image;
class Attachment
{
    private $_model;

    public function __construct() {
        if( !$this->_model ) $this->_model = new AttachmentInfoModel();
    }

    /***
     * 上传到阿里云
     * @param $field
     * @param $request
     * @param string $tag
     * @param float|int $size
     * @param array $mimeType
     * @return mixed
     */
    public function aliUpload($field, $request, $size = 10 * 1024 * 1024, array $mimeType = ['image/jpeg', 'image/png', 'image/gif','video/mp4','video/quicktime']){

        $class = isset($request['class']) ? $request['class'] : 1;

        $file = $request[$field];

        if ($file === null) {
            return $this->_jsonMessage(500,  ['message' => '没有文件被上传']);
        }
        if (!$file->isValid()) {
            return $this->_jsonMessage(500,  ['message' => '不允许上传']);
        }

        $fileSize = $file->getSize();
        if ($fileSize > $size) {
            return $this->_jsonMessage(500,  ['message' => '文件大小超过限制']);
        }
        $fileMimeType = $file->getMimeType();
        if (!empty($mimeType) && !in_array($fileMimeType, $mimeType)) {
            return $this->_jsonMessage(500,  ['message' => '文件格式不被允许']);
        }

        $clientName = $file->getClientOriginalName();
        $md5 = md5($clientName . time());
        $md5_filename = $md5 . '.' . $file->getClientOriginalExtension();

        $file_Path = $file->getRealPath();

        try {
            $ok = OSS::publicUpload(config('alioss.BucketName'),$md5_filename, $file_Path);

            if(!$ok){
                return $this->_jsonMessage(500,  ['message' => '上传失败']);
            }

            $attachment = new AttachmentInfoModel();
            $attachment->name = $clientName;
            $attachment->md5 = $md5;
            $attachment->path = config('alioss.FileUrl').$md5_filename;
            $attachment->url = config('alioss.FileUrl').$md5_filename;
            $attachment->size = $fileSize;
            $attachment->file_type = $fileMimeType;
            $attachment->class = $class;
            if ($attachment->save()) {
                return $this->_jsonMessage(200,  ['message' => "上传成功", 'fileurl' => config('alioss.FileUrl').$md5_filename,'name'=>$md5_filename]);
            } else {
                OSS::publicDeleteObject(config('alioss.BucketName'),$md5_filename);
                return $this->_jsonMessage(500,  ['message' => '数据库保存错误']);
            }
        } catch (FileException $e) {
            return $this->_jsonMessage(500,  ['message' => '保存失败']);
        }

    }

    public function _jsonMessage($status,$ret){
        $ret['code'] = $status;
        return $ret;
    }


    /**
     * 上传到本地
     *
     * @param string|array $field 文件key
     * @param Request $request  laravel's http request
     * @param string $tag       文件tag
     * @param int $size         文件size限制，默认2M
     * @param array $mimeType   文件mime类型限制，默认不限
     * @return array|string|int 返回：md5字串|ErrorCode或[md5字串|ErrorCode]
     */


    public function localUpload($field, $request, $size = 10 * 1024 * 1024, array $mimeType = ['image/jpeg', 'image/png', 'image/gif','video/mp4','video/quicktime'])
    {
        $tag = $request['folder'];
        $class = isset($request['class']) ? $request['class'] : 1;
        $width = isset($request['width']) ? $request['width'] : 0;
        $height = isset($request['height']) ? $request['height'] : 0;
        $rel_path = '/upload/images/'.$tag . '/' . date('Ymd');
        $path = public_path() . $rel_path;

        if (!file_exists($path)) {
            if (!@mkdir($path, 0755, true)) {
                return $this->_jsonMessage(500,  ['message' => '目录创建失败']);
            }
        }

        $file = is_array($request[$field])?$request[$field][0]:$request[$field];

        if ($file === null) {
            return $this->_jsonMessage(500,  ['message' => '没有文件被上传']);
        }

        if (!$file->isValid()) {
            return $this->_jsonMessage(500,  ['message' => '不允许上传']);
        }

        $fileSize = $file->getSize();
        if ($fileSize > $size) {
            return $this->_jsonMessage(500,  ['message' => '文件大小超过限制']);
        }

        $fileMimeType = $file->getMimeType();
        if (!empty($mimeType) && !in_array($fileMimeType, $mimeType)) {
            return $this->_jsonMessage(500,  ['message' => '文件格式不被允许']);
        }
        $clientName = $file->getClientOriginalName();
        $md5 = md5($clientName . time());
        $md5_filename = $md5 . '.' . $file->getClientOriginalExtension();

        try {
            if(!$file->move($path, $md5_filename)){
                return $this->_jsonMessage(500,  ['message' => '上传失败']);
            }

            $real_path = $path . '/' . $md5_filename;
            $url_path = $rel_path . '/' . $md5_filename;

            $source_info = null;
            if(($source_info = getimagesize($real_path)) != null) {
                $source_width = $source_info[0];
                $source_height = $source_info[1];
                \Log::info('$source_width'.$source_width.'$source_height'.$source_height);

                if($width || $height){
                    if($width==0){
                        $width = $source_width*($height/$source_height);
                    }
                    if($height==0){
                        $height = $source_height*($width/$source_width);
                    }
                    \Log::info('$width'.$width.'$height'.$height);
                    Image::make($real_path)->resize($width, $height)->save($real_path);
                }

            }

            $attachment = new AttachmentInfoModel();
            $attachment->name = $clientName;
            $attachment->md5 = $md5;
            $attachment->path = $real_path;
            $attachment->url = $url_path;
            $attachment->size = $fileSize;
            $attachment->file_type = $fileMimeType;
            $attachment->class = $class;
            if ($attachment->save()) {
                return $this->_jsonMessage(200,  ['message' => "上传成功", 'fileurl' => $url_path,'name'=>$md5_filename]);

            } else {
                @unlink($real_path);
                return $this->_jsonMessage(500,  ['message' => '数据库保存错误']);
            }
        } catch (FileException $e) {
            return $this->_jsonMessage(500,  ['message' => '上传失败']);
        }
    }



    public function fileUpload($field, $request, $tag = 'files', $size = 10 * 1024 * 1024, array $mimeType = ['image/jpeg', 'image/png', 'image/gif','video/mp4','video/quicktime','text/plain']){
        $tag = $request['folder'];
        $class = isset($request['class']) ? $request['class'] : 1;
        $width = isset($request['width']) ? $request['width'] : 0;
        $height = isset($request['height']) ? $request['height'] : 0;
        $rel_path = $tag . '/' . date('Ymd');
        $path = public_path() . $rel_path;

        if (!file_exists($path)) {
            if (!@mkdir($path, 0755, true)) {
                return $this->_jsonMessage(500,  ['message' => '目录创建失败']);
            }
        }

        $file = $request[$field];
        if ($file === null) {
            return $this->_jsonMessage(500,  ['message' => '没有文件被上传']);
        }
        if (!$file->isValid()) {
            return $this->_jsonMessage(500,  ['message' => '不允许上传']);
        }

        $fileSize = $file->getSize();
        if ($fileSize > $size) {
            return $this->_jsonMessage(500,  ['message' => '文件大小超过限制']);
        }
        $fileMimeType = $file->getMimeType();

        if (!empty($mimeType) && !in_array($fileMimeType, $mimeType)) {
            return $this->_jsonMessage(500,  ['message' => '文件格式不被允许']);
        }
        $clientName = $file->getClientOriginalName();
        $md5 = md5($clientName . time());
        $md5_filename = $md5 . '.' . $file->getClientOriginalExtension();

        try {
            if(!$file->move($path, $md5_filename)){
                return $this->_jsonMessage(500,  ['message' => '上传失败']);
            }

            $real_path = $path . '/' . $md5_filename;
            $url_path = $rel_path . '/' . $md5_filename;

            $source_info = null;
            if(($source_info = getimagesize($real_path)) != null) {
                $source_width = $source_info[0];
                $source_height = $source_info[1];
                \Log::info('$source_width'.$source_width.'$source_height'.$source_height);
                if($width || $height){
                    if($width==0){
                        $width = $source_width*($height/$source_height);
                    }
                    if($height==0){
                        $height = $source_height*($width/$source_width);
                    }
                    \Log::info('$width'.$width.'$height'.$height);
                    Image::make($real_path)->resize($width, $height)->save($real_path);
                }
            }

            return $this->_jsonMessage(200,  ['message' => "上传成功", 'fileurl' => $url_path,'name'=>$md5_filename]);

        } catch (FileException $e) {
            return $this->_jsonMessage(500,  ['message' => '上传失败']);
        }
    }


    /**
     * 删除附件
     *
     * @param $md5 string 删除文件的md5码
     * @return int 错误码or 0（成功）
     */
    public function deleteAttachment($md5) {
        $attachment = $this->_model->where(['md5' => $md5])->first();
        if (!$attachment) {
            return ErrorCode::ATTACHMENT_NOT_EXIST;
        }
        if (file_exists($attachment->path)) {
            if (@unlink($attachment->path)) {
                if ($attachment->delete()) {
                    return 0;
                } else {
                    return ErrorCode::ATTACHMENT_RECORD_DELETE_FAILED;
                }
            } else {
                return ErrorCode::ATTACHMENT_DELETE_FAILED;
            }
        } else {
            return ErrorCode::ATTACHMENT_NOT_EXIST;
        }

    }

}
