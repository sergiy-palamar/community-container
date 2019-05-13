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
 * Class FindCommunityAdminsAction
 * @package App\Containers\Community\Actions
 */
class FindCommunityAdminsAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $users = Apiato::call('Community@FindCommunityAdminsTask', [$request->id]);

        return $users;
    }
}
