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
 * Class CreateCommunityAction
 * @package App\Containers\Community\Actions
 */
class CreateCommunityAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $user = auth('api')->user();

        $data = $request->sanitizeInput([
            'title',
            'description',
            'id_code',
            'address',
        ]);

        if ($request->start_date) {
            $data['start_date'] = $request->start_date;
        }

        if ($request->connection_date) {
            $data['connection_date'] = $request->connection_date;
        }

        if ($request->end_date) {
            $data['end_date'] = $request->end_date;
        }

        if ($request->forever_active) {
            $data['forever_active'] = $request->forever_active;
        }

        if ($request->is_private !== null) {
            $data['is_private'] = (bool)$request->is_private;
        }

        $community = Apiato::call('Community@CreateCommunityTask', [$data]);

        if ($user->is(RoleInterface::COMMUNITY_ADMIN_ROLE_NAME)) {
            return Apiato::call('User@AssigneeToCommunityTask', [$user, $community]);
        }

        return $community;
    }
}
