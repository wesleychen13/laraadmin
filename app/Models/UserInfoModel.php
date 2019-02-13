<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * @description 用户表
 * @author  system;
 * @version    1.0
 * @date 2017-05-30 12:16:56
 *
 */
class UserInfoModel extends Authenticatable
{
    use HasApiTokens;
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'user_info';
    /**
     * 主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'mobile',
        'avatar',
        'sex',
    ];

}