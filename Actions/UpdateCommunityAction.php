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
 * Class UpdateCommunityAction
 * @package App\Containers\Community\Actions
 */
class UpdateCommunityAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        /**
         * @var $loggedUser \App\Containers\User\Models\User
         */
        $loggedUser = auth('api')->user();

        $data = $request->sanitizeInput([
            'title',
            'description',
            'address',
            'forever_active',
            'start_date',
            'end_date',
        ]);


        if ($request->connection_date && $loggedUser->is(RoleInterface::COMMUNITY_ADMIN_ROLE_NAME)) {
            $data['connection_date'] = $request->connection_date;
        }

        $data['verification_code'] = Apiato::call('Invitation@GenerateUniqueInvitationCodeTask');

        $community = Apiato::call('Community@UpdateCommunityTask', [$request->id, $data]);

        return $community;
    }
}
