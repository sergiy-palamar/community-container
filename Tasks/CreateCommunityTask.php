<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class CreateCommunityTask
 * @package App\Containers\Community\Tasks
 */
class CreateCommunityTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * CreateCommunityTask constructor.
     * @param CommunityRepository $repository
     */
    public function __construct(CommunityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws CreateResourceFailedException
     */
    public function run(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
