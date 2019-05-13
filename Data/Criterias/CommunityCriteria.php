<?php

namespace App\Containers\Community\Data\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class CommunityCriteria
 * @package App\Containers\Community\Data\Criterias
 */
class CommunityCriteria extends Criteria
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
     * @param $model
     * @param PrettusRepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $user = auth('api')->user();

        $model
            ->join('user_community', 'user_community.community_id', '=', 'communities.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'user_community.user_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('user_community.user_id', $user->id)
            ->where('roles.name', 'community_admin');

        $search = $this->request->get(config('repository.criteria.params.search', 'search'), null);
        if ($search) {
            $currentDate = new \DateTime('now');
            $search = $this->parserSearchValues($search);

            $model = $model->where(function ($query) use ($search, $currentDate) {
                /** @var Builder $query */
                $modelTableName = $query->getModel()->getTable();

                /**
                 * upcoming
                 */
                if (isset($search['upcoming']) && $search['upcoming']) {
                    $query->where($modelTableName.'.start_date', ">", $currentDate);
                }

                /**
                 * current
                 */
                if (isset($search['current']) && $search['current']) {
                    $query->where($modelTableName.'.start_date', "<=", $currentDate);
                    $query->where($modelTableName.'.end_date', ">=", $currentDate);
                }

                /**
                 * past
                 */
                if (isset($search['past']) && $search['past']) {
                    $query->where($modelTableName.'.end_date', "<", $currentDate);
                }
            });
        }
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
