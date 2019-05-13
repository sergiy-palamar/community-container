<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Exceptions\CommunityNotFoundException;
use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Containers\Community\Models\Community;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class FindCommunityByIdCodeTask
 * @package App\Containers\Community\Tasks
 */
class FindCommunityByIdCodeTask extends Task
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
     * @param string $idCode
     * @return Community
     * @throws CommunityNotFoundException
     */
    public function run(string $idCode): Community
    {
        try {
            $community = $this->repository->findWhere(
                [
                    'id_code' => $idCode,
                ]
            )->first();
            if (!$community) {
                throw new Exception();
            }
            return $community;
        } catch (Exception $exception) {
            throw new CommunityNotFoundException();
        }
    }
}
