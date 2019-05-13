<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Containers\Community\Exceptions\CommunityNotFoundException;

/**
 * Class FindCommunityByIdTask
 * @package App\Containers\Community\Tasks
 */
class FindCommunityByIdTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * FindCommunityByIdTask constructor.
     * @param CommunityRepository $repository
     */
    public function __construct(CommunityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws CommunityNotFoundException
     */
    public function run($id)
    {
        try {
            $community =  $this->repository->findByField('id', $id)->first();
            if (!$community) {
                throw new \Exception();
            }
            return $community;
        } catch (Exception $exception) {
            throw new CommunityNotFoundException();
        }
    }
}
