<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Containers\User\Exceptions\UserNotFoundException;

/**
 * Class FindCommunityAdminsTask
 * @package App\Containers\Community\Tasks
 */
class FindCommunityAdminsTask extends Task
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * FindCommunityAdminsTask constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws UserNotFoundException
     */
    public function run($id)
    {
        try {
            $users = $this->repository
                ->scopeQuery(
                    function ($query) use ($id) {
                        return
                            $query
                                ->join('user_community', 'user_community.user_id', '=', 'users.id')
                                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                ->where('user_community.community_id', $id)
                                ->where('roles.name', 'community_admin')
                            ;
                    }
                )->all(['users.*']);

            return $users;
        } catch (Exception $exception) {
            throw new UserNotFoundException();
        }
    }
}
