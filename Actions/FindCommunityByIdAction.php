<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Contract\RoleInterface;

/**
 * Class FindCommunityByIdAction
 * @package App\Containers\Community\Actions
 */
class FindCommunityByIdAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $user = auth('api')->user();

        $community = Apiato::call('Community@FindCommunityByIdTask', [$request->id]);

        if ($user->is(RoleInterface::ADMIN_ROLE_NAME)) {
            return $community;
        }

        if ($community->hasUser($user->id)) {
            return $community;
        }

        return [];
    }
}
