<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Repositories\Base\Criteria\OrderBy;
use App\Repositories\User\Criteria\MultiWhere;
use App\Repositories\User\InfoRepository;

class InfoController extends Controller
{
    private $repository;

    public function __construct(InfoRepository $repository)
    {
        if (!$this->repository) $this->repository = $repository;
    }

    function index(Request $request)
    {
        $search['keyword'] = $request->input('keyword');
        $query = $this->repository->pushCriteria(new MultiWhere($search));

        if (isset($request['sort_field']) && $request['sort_field'] && isset($request['sort_field_by'])) {
            $query = $query->pushCriteria(new OrderBy($request['sort_field'], $request['sort_field_by']));
        } else {
            $query = $query->pushCriteria(new OrderBy('id', 'DESC'));
        }
        $list = $query->paginate(16);
        return view('admin.user.info.index', compact('list'));
    }



    /**
     * 添加
     *
     */
    public function create(Request $request)
    {
        if ($request->method() == 'POST') {
            return $this->_createSave();
        }
        return view('admin.user.info.edit');
    }

    /**
     * 保存修改
     */
    private function _createSave()
    {
        $data = (array)request('data');
        $id = $this->repository->create($data);
        if ($id) {
            $url[] = array('url' => U('User/Info/index'), 'title' => '返回列表');
            $url[] = array('url' => U('User/Info/create'), 'title' => '继续添加');
            $this->showMessage('添加成功', $url);
        } else {
            $url[] = array('url' => U('User/Info/index'), 'title' => '返回列表');
            return $this->showWarning('添加失败', $url);
        }
    }

    /**
     *
     * 修改
     *
     */
    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            return $this->_updateSave();
        }
        $data = $this->repository->find($request->get('id'));
        return view('admin.user.info.edit', compact('data'));
    }

    /**
     * 保存修改
     */
    private function _updateSave()
    {
        $data = (array)request('data');
        $ok = $this->repository->update(request('id'), $data);
        if ($ok) {
            $url[] = array('url' => U('User/Info/index'), 'title' => '返回列表');
            return $this->showMessage('操作成功', urldecode(request('_referer')));
        } else {
            $url[] = array('url' => U('User/Info/index'), 'title' => '返回列表');
            return $this->showWarning('操作失败', $url);
        }
    }

    public function view(Request $request)
    {
        $data = $this->repository->find(request('id'));
        return view('admin.user.info.view', compact('data'));
    }


    /**
     *
     * 状态改变
     *
     */
    public function status(Request $request)
    {
        $ok = $this->repository->updateStatus(request('id'), request('status'));
        if ($ok) {
            return $this->showMessage('操作成功');
        } else {
            return $this->showWarning('操作失败');
        }
    }

    /**
     * 删除
     */
    public function destroy(Request $request)
    {
        $bool = $this->repository->destroy($request->get('id'));
        if ($bool) {
            return $this->showMessage('操作成功');
        } else {
            return $this->showWarning("操作失败");
        }
    }
}