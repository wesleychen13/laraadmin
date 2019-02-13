<?php

namespace App\Models;

class AttachmentInfoModel extends BaseModel
{
    //
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'attachment_info';
    /**
     * 主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = PAGE_NUMS;
}
