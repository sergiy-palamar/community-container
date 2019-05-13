<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Containers\Community\Models\Community;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Containers\User\Models\User;
use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class IsCommunityActiveTask
 * @package App\Containers\Community\Tasks
 */
class IsCommunityActiveTask extends Task
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
     * @param Community $community
     * @return bool
     */
    public function run(Community $community): bool
    {
        try {
            $startDate = date_timestamp_get($community->start_date);
            $checkOut = date_timestamp_get($community->end_date);
            $current = date_timestamp_get(new \DateTime());

            return $current <= $startDate || $current <= $checkOut || $community->forever_active;
        } catch (Exception $exception) {
        }

        return false;
    }
}
