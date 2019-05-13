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
use App\Containers\User\Models\User;
use App\Containers\Community\Models\Community;
use Apiato\Core\Foundation\Facades\Apiato;
use Illuminate\Database\Eloquent\Collection;
use App\Containers\Community\Data\Criterias\MemberCriteria;
use Illuminate\Http\Request;

/**
 * Class GetCommunityWithStatusPerUserTask
 * @package App\Containers\Community\Tasks
 */
class GetCommunityWithStatusPerUserProfileTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * @var Request
     */
    protected $request;

    /**
     * GetCommunityWithStatusPerUserTask constructor.
     * @param CommunityRepository $repository
     * @param Request $request
     */
    public function __construct(
        CommunityRepository $repository,
        Request $request
    ) {
        $this->repository = $repository;
        $this->request = $request;
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function run(User $user)
    {
        $currentCommunities =  $user->community()->get();
        try {
            foreach ($currentCommunities as &$currentCommunity) {
                $isActive = Apiato::call('Community@IsCommunityActiveForUserTask', [$user, $currentCommunity]);
                if (!$isActive) {
                    $currentCommunity->setStatus(Community::NOT_ACTIVE_STATUS);
                }
            }
        } catch (Exception $exception) {
        }
        return collect($currentCommunities);
    }
}
