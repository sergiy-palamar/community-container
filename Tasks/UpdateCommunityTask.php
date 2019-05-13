<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class UpdateCommunityTask
 * @package App\Containers\Community\Tasks
 */
class UpdateCommunityTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * UpdateCommunityTask constructor.
     * @param CommunityRepository $repository
     */
    public function __construct(CommunityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws UpdateResourceFailedException
     */
    public function run($id, array $data)
    {
        try {
            return $this->repository->update($data, $id);
        } catch (Exception $exception) {
            throw new UpdateResourceFailedException(
                (new UpdateResourceFailedException())->getMessage() . " " . $exception->getMessage()
            );
        }
    }
}
