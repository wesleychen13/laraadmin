<?php
/**
 *------------------------------------------------------
 * AdminUserModel.php
 *------------------------------------------------------
 *
 * @author    m@9026.com
 * @date      2017/03/21 10:15
 * @version   V1.0
 *
 */

namespace App\Models;

use App\Services\Admin\Acl;
use App\Services\Admin\Menus;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUserModel extends Authenticatable
{
    /**
     * 数据表名
     */
    protected $table = "admin_users";

    /**
     * 主键
     */
    protected $primaryKey = "id";

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'username',
        'real_name',
        'password',
        'email',
        'mobile',
        'avatar',
        'type',
        'last_login_time',
        'status',
        'is_root',
        'admin_role_id'
    ];


    public function getMenus(){
        if($this->is_root) {
            $obj = new Menus();
            $menus = $obj->search(array('level'=>2,'display'=>1),$orderby=array('sort'=>'desc'),$pagesize = 100000);
            $menus = $menus->toArray();
            $menus = list_to_tree($menus['data']);
        }else{
            $obj = new Acl();
            $data = $obj->getRoleMenu($this->admin_role_id);
            $menus = list_to_tree($data);
        }
        return $menus;
    }

}