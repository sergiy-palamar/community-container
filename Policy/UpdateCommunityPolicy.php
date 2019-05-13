<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Policy;

use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Contract\RoleInterface;

/**
 * Class UpdateCommunityPolicy
 * @package App\Containers\Community\Policy
 */
class UpdateCommunityPolicy implements UpdateCommunityPolicyInterface
{

    /**
     * @param Request $request
     * @return bool
     */
    public function execute(Request $request): bool
    {
        $loggedUser = auth('api')->user();

        if (!$loggedUser->is(RoleInterface::ADMIN_ROLE_NAME)) {
            /**
             * @var $community \App\Containers\Community\Models\Community
             */
            $community = Apiato::call('Community@FindCommunityByIdTask', [$request->id]);

            return ($community->hasUser($loggedUser->id) && $loggedUser->is(RoleInterface::COMMUNITY_ADMIN_ROLE_NAME));
        }

        return true;
    }
}
