<?php

namespace App\Containers\Community\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Http\Request;
use App\Contract\RoleInterface;

/**
 * Class MemberCriteria
 * @package App\Containers\User\Data\Criterias
 */
class MemberCriteria extends Criteria
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
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $user = auth('api')->user();

        if (!$user->is(RoleInterface::ADMIN_ROLE_NAME)) {
            $model
                ->join('user_community', 'user_community.community_id', '=', "{$model->getModel()->getTable()}.id")
                ->where('user_community.user_id', $user->id)
            ;
        }

        $search = $this->request->get(config('repository.criteria.params.search', 'search'), null);
        if ($search) {
            $currentDate = new \DateTime('now');
            $search = $this->parserSearchValues($search);

            /**
             * likes
             */
            if (isset($search['likes']) && $search['likes']) {
                $model
                    ->leftJoin('likes', 'likes.entity_id', '=', "{$model->getModel()->getTable()}.id");
            }

            $model = $model->where(function ($query) use ($search, $currentDate) {

                /** @var Builder $query */
                $modelTableName = $query->getModel()->getTable();

                /**
                 * upcoming
                 */
                if (isset($search['upcoming']) && $search['upcoming']) {
                    $query->orWhere($modelTableName.'.start_date', ">=", $currentDate);
                }

                /**
                 * current
                 */
                if (isset($search['current']) && $search['current']) {
                    $query->orWhere(function ($query) use ($search, $currentDate) {
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
                    $query->orWhere($modelTableName.'.end_date', "<", $currentDate);
                }

                /**
                 * likes
                 */
                if (isset($search['likes']) && $search['likes']) {
                    $query->orWhere('likes.entity_type', 'community');
                }
            });
        }
        $model->groupBy(["{$model->getModel()->getTable()}.id"]);

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
