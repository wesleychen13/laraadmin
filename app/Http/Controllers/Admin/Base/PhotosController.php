<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\Attachment;
use App\Models\AttachmentInfoModel;
use App\Models\AttachmentClassModel;
use App\Services\OSS;
use Illuminate\Http\Request as HttpRequest;
use Request;
use File;

class PhotosController extends Controller
{
    private $_serviceAttachment;

    public function __construct()
    {
        if (!$this->_serviceAttachment) $this->_serviceAttachment = new Attachment();
    }

    public function index(HttpRequest $request)
    {
        $classes = AttachmentClassModel::all();
        $a_class = $request->has('class') ? $request->input('class') : null;

        if(($a_class = AttachmentClassModel::find($a_class)) == null) {
            $a_class = AttachmentClassModel::first();
        }

        $currentQuery = new AttachmentInfoModel();

        if ($request->get('start')) {
            $start = $request->get('start');
            $currentQuery = $currentQuery->where(function ($query) use ($start) {
                $query->where('created_at', '>=', $start);
            });
        }

        if ($request->has('end') && !empty($request->get('end'))) {
            $end = $request->get('end');
            $currentQuery = $currentQuery->where(function ($query) use ($end) {
                $query->where('created_at', '<=', $end);
            });
        }

        if($request->has('class') &&  !empty($request->input('class'))){
            $class = $request->input('class');
            $currentQuery = $currentQuery->where(function ($query) use ($class) {
                $query->where('class', $class);
            });
        }


        $photos = $currentQuery->paginate(24);

        return view('admin.base.photos.index', compact('photos', 'classes','a_class'));
    }


    public function move(HttpRequest $request)
    {
        if (Request::method() != 'POST') {
            return back();
        }

        $ids = explode(',', $request->input('ids'));
        $class = AttachmentClassModel::find($request->input('class'));
        AttachmentInfoModel::whereIn('id', $ids)->update(['class' => $class->id]);
        return back();
    }

    public function delete(HttpRequest $request)
    {
        if (Request::method() != 'POST') {
            return back();
        }

        $ids = explode(',', $request->input('ids'));
        $photos = AttachmentInfoModel::find($ids);
        foreach ($photos as $photo) {
            if ($photo->path == $photo->url) {
                $key = explode('/', $photo->path);
                OSS::publicDeleteObject(config('alioss.BucketName'), end($key));
            } else {
                File::delete($photo->path);
            }
            $photo->delete();

        }
        return back();
    }

}
