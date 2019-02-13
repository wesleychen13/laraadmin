<?php

namespace App\Repositories\User\Criteria;
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
        if(isset($this->search['keyword']) && ! empty($this->search['keyword'])) {
            $keywords = '%' . $this->search['keyword'] . '%';
            $model = $model->where(function ($query) use ($keywords) {
                $query->where('id'  , 'like', $keywords)
                    ->orwhere('username', 'like', $keywords)
                    ->orwhere('email', 'like', $keywords)
                    ->orwhere('mobile', 'like', $keywords);
            });
        }
        return $model;
    }

}