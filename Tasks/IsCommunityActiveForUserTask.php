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
use App\Containers\User\Models\User;
use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class IsCommunityActiveForUserTask
 * @package App\Containers\Community\Tasks
 */
class IsCommunityActiveForUserTask extends Task
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
     * @param User $user
     * @param Community $community
     * @return bool
     */
    public function run(User $user, Community $community): bool
    {
        try {
            $invitation = Apiato::call(
                'Invitation@FindInvitationByUserEmailAndCommunityIdTask',
                [$user->email,$community->id]
            );
            if ($invitation) {
                $checkIn = date_timestamp_get($invitation->check_in);
                $checkOut = date_timestamp_get($invitation->check_out);
                $current = date_timestamp_get(new \DateTime());

                return ($checkIn <= $current && $current <= $checkOut) || ($community->forever_active);
            }

        } catch (Exception $exception) {
        }

        return false;
    }
}
