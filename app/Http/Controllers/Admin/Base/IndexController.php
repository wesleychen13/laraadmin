<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Controller;
use App\Services\Base\BaseArea;
use App\Services\Admin\Menus;
use App\Services\Admin\Acl;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function index() {
        return view('admin.base.index.index');
    }

    function welcome() {
        return 'Welcome';
    }


}