<?php

namespace App\Containers\Community\Data\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use App\Contract\RoleInterface;

/**
 * Class PrivateCommunityCriteria
 * @package App\Containers\Community\Data\Criterias
 */
class PrivateCommunityCriteria implements CriteriaInterface
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
        /**
         * @var $user \App\Containers\User\Models\User
         */
        $user = auth()->user();

        if ($user->is(RoleInterface::MEMBER_ROLE_NAME)) {
            return $model->where('is_private', false);
        }

        return $model;
    }
}
