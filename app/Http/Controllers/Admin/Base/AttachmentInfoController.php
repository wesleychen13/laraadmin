<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\Attachment;
use App\Models\AttachmentInfoModel;
use Request, Response;

class AttachmentInfoController extends Controller
{
    private $_serviceAttachment;

    public function __construct()
    {
        if (!$this->_serviceAttachment) $this->_serviceAttachment = new Attachment();

    }


    /**
     * 文件上传
     */
    public function upload()
    {
        $request = Request::all();

        if (isset($request['position']) && $request['position'] == 'alioss') {
            $this->_uploadToAlioss($request);
        } else {
            $this->_uploadToLocal($request);
        }
    }


    /***
     * 文件上传
     */
    public function fileupload()
    {
        $request = request()->all();
        $data = $this->_serviceAttachment->fileUpload('file', $request, 'files');
        echo json_encode($data);
        exit;
    }

    /**
     * 上传到阿里云
     */
    private function _uploadToAlioss($request)
    {
        $return = [];
        if (isset($request['editor'])) {
            $data = $this->_serviceAttachment->aliUpload('upfile', $request);
            if ($data['code'] === 200) {
                \Log::info(json_encode($data));
                $return['state'] = 'SUCCESS';
                $return['url'] = $data['fileurl'];
                $return['title'] = $data['name'];
            } else {
                $return['error'] = 1;
                $return['message'] = $data['message'];
            }
        } else {
            $return = $this->_serviceAttachment->aliUpload('file', $request);
        }
        echo json_encode($return);
        exit;
    }

    /**
     * 上传到本地
     */
    public function _uploadToLocal($request)
    {
        $return = [];
        if (isset($request['editor'])) {
            $data = $this->_serviceAttachment->localUpload('upfile', $request);
            if ($data['code'] === 200) {
                \Log::info(json_encode($data));
                $return['state'] = 'SUCCESS';
                $return['url'] = $data['fileurl'];
                $return['title'] = $data['name'];
            } else {
                $return['error'] = 1;
                $return['message'] = $data['message'];
            }
        } else {
            $return = $this->_serviceAttachment->localUpload('file', $request);
        }
        echo json_encode($return);
        exit;
    }


    /**
     * @api {get} /api/attachment/download/{md5} 下载文件（图片）
     * @apiDescription 下载文件（图片）(get code)
     * @apiGroup Attachment
     * @apiPermission none
     * @apiVersion 0.1.0
     * @apiParam {string} md5   图片md5码
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       文件二进制码
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not found
     */
    public function download()
    {
        $request = Request::all();
        $attachment = AttachmentInfoModel::where(['md5' => $request['md5']])->first();
        if (!$attachment) {
            return view('errors.404');
        }

        return Response::download($attachment->path, $attachment->name, [
            'Content-type' => $attachment->file_type,
            'Accept-Ranges' => 'bytes',
            'Accept-Length' => $attachment->size,
        ]);
    }

    public function remove(){
        $request = Request::all();
        $file = AttachmentInfoModel::where(['url' => $request['file']])->first();
        if($file){
            $md5 = $file->md5;
            $this->_serviceAttachment->deleteAttachment($md5);
        }

        $data = [
            'code' => 200,
            'msg' => '移除成功',
            'data' => $request['file']
        ];


        echo json_encode($data);
        exit;
    }


}
