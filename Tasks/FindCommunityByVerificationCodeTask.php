<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Containers\Community\Models\Community;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Containers\Community\Exceptions\CommunityNotFoundException;

/**
 * Class FindCommunityByVerificationCodeTask
 * @package App\Containers\Community\Tasks
 */
class FindCommunityByVerificationCodeTask extends Task
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
     * @param string $verificationCode
     * @return Community
     * @throws CommunityNotFoundException
     */
    public function run(string $verificationCode): Community
    {
        try {
            $comunity =  $this->repository->findWhere(
                [
                    'verification_code' => $verificationCode,
                ]
            )->first();
            if (!$comunity) {
                throw new CommunityNotFoundException();
            }
        } catch (Exception $exception) {
            throw new CommunityNotFoundException();
        }
        return $comunity;
    }
}
