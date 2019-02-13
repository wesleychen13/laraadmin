<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request as HttpRequest;
use App\Http\Controllers\Admin\Controller;
use App\Models\AttachmentClassModel;
use App\Models\AttachmentInfoModel;
use Request, Response, Validator, File;

class AttachmentClassController extends Controller
{
    public function add(HttpRequest $request)
    {
        if (!$request->has('class') || Request::method() != 'POST') {
            return back();
        }

        $validator = Validator::make($request->all(), [
            'class' => 'required|string|max:100|unique:attachment_classes,class',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('my-error', '分类已存在！');
            return back()->withErrors($validator)->withInput();
        }

        $class = new AttachmentClassModel;
        $class->class = $request->input('class');
        if (!$class->save()) {
            $validator->errors()->add('my-error', '添加分类失败！');
            return back()->withErrors($validator)->withInput();
        }

        return back();
    }

    public function delete(HttpRequest $request)
    {
        if (Request::method() != 'POST') {
            return back();
        }

        $class = null;
        if ($request->has('class') && ($class = AttachmentClassModel::find($request->input('class'))) != null) {
            if ($class->class == '未分类') {
                return back();
            }

            $photos = AttachmentInfoModel::where('class', $class->id)->get();
            foreach ($photos as $photo) {
                File::delete($photo->path);
                $photo->delete();
            }
            $class->delete();
        }
        return redirect('admin/Base/Photos/index');
    }
}
