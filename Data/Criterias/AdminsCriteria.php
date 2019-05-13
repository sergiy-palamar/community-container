<?php

namespace App\Containers\Community\Data\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class AdminsCriteria
 * @package App\Containers\Community\Data\Criterias
 */
class AdminsCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * AdminsCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $search = $this->request->get(config('repository.criteria.params.search', 'search'), null);
        if ($search) {
            $currentDate = new \DateTime('now');
            $search = $this->parserSearchValues($search);

            /**
             * upcoming
             */
            if (isset($search['upcoming']) && $search['upcoming']) {
                $model->orWhere($model->getModel()->getTable().'.start_date', ">=", $currentDate);
            }

            /**
             * current
             */
            if (isset($search['current']) && $search['current']) {
                $model = $model->orWhere(function ($query) use ($search, $currentDate) {
                    /** @var Builder $query */
                    $modelTableName = $query->getModel()->getTable();
                    if (isset($search['current']) && $search['current']) {
                        $query->where($modelTableName.'.start_date', "<", $currentDate);
                        $query->where($modelTableName.'.end_date', ">", $currentDate);
                    }
                });
            }

            /**
             * past
             */
            if (isset($search['past']) && $search['past']) {
                $model->orWhere($model->getModel()->getTable().'.end_date', "<", $currentDate);
            }


            /**
             * likes
             */
            if (isset($search['likes']) && $search['likes']) {
                $model
                    ->leftJoin('likes', 'likes.entity_id', '=', 'communities.id')
                    ->orWhere('likes.entity_type', 'community');
            }
        }

        $model->groupBy(['communities.id']);

        return $model;
    }

    /**
     * @param $search
     * @return array
     */
    protected function parserSearchValues($search)
    {
        $searchValues = [];
        if (stripos($search, ';') || stripos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                $s = explode(':', $value);
                $searchValues[$s[0]] = $s[1];
            }
        }

        return $searchValues;
    }
}
