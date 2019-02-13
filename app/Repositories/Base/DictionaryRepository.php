<?php
/**
 *   字典管理
 *  @author  system
 *  @version    1.0
 *  @date 2018-06-12 10:14:19
 *
 */
namespace App\Repositories\Base;

use App\Repositories\Base\Repository;


class DictionaryRepository extends Repository {

    public function model() {
        return \App\Models\BaseDictionaryModel::class;
    }

    
}
