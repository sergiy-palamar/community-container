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
 * Class FindCommunityUsersTask
 * @package App\Containers\Community\Tasks
 */
class FindCommunityUsersTask extends Task
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * FindCommunityUsersTask constructor.
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
                                ->where('user_community.community_id', $id);
                    }
                )
                ->paginate();

            return $users;
        } catch (Exception $exception) {
            throw new UserNotFoundException();
        }
    }
}
