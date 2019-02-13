<?php
namespace App\Repositories\User;

use App\Repositories\Base\Repository;


class InfoRepository extends Repository {

    public function model() {
        return \App\Models\UserInfoModel::class;
    }

    
}
