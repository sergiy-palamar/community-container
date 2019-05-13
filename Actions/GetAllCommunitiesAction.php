<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Actions;

use App\Contract\RoleInterface;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class GetAllCommunitiesAction
 * @package App\Containers\Community\Actions
 */
class GetAllCommunitiesAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        /**
         * @var $user \App\Containers\User\Models\User
         */
        $user = auth('api')->user();

        if ($user->is(RoleInterface::ADMIN_ROLE_NAME)) {
            return Apiato::call(
                'Community@GetAllCommunitiesTask',
                [],
                [
                    'admins',
                    'addRequestCriteria',
                ]
            );
        }

        if ($user->is(RoleInterface::MEMBER_ROLE_NAME)) {
            return Apiato::call(
                'Community@GetAllCommunitiesTask',
                [],
                [
                    'admins',
                    'private',
                    'addRequestCriteria',
                ]
            );
        }

        if ($user->is(RoleInterface::COMMUNITY_ADMIN_ROLE_NAME)) {
            return Apiato::call(
                'Community@GetAllCommunitiesTask',
                [],
                [
                    'communityAdmin',
                    'addRequestCriteria',
                ]
            );
        }
    }
}
