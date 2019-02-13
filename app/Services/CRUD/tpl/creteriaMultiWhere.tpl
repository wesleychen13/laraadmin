<?php
namespace App\Repositories\{{sortPath}}\Criteria;
use App\Repositories\Base\Criteria;
use App\Repositories\Contracts\RepositoryInterface as Repository;

class MultiWhere extends Criteria {

    private $search = [];

    /**
     * MultiWhere constructor.
     * @param array $search
     *
     */
    public function __construct(array $search)
    {
        $this->search = $search;
    }

    /**
    * @param $model
    * @param RepositoryInterface $repository
    * @return mixed
    */
    public function apply($model, Repository $repository)
    {
         {{queryKeyord}}
         return $model;
    }

}