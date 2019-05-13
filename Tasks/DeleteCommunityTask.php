<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class DeleteCommunityTask
 * @package App\Containers\Community\Tasks
 */
class DeleteCommunityTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * DeleteCommunityTask constructor.
     * @param CommunityRepository $repository
     */
    public function __construct(CommunityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return int
     * @throws DeleteResourceFailedException
     */
    public function run($id)
    {
        try {
            return $this->repository->delete($id);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
