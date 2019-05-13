<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Community\Models\Community;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class GetAttachmentsPerCommunityAction
 * @package App\Containers\Community\Actions
 */
class GetAttachmentsPerCommunityAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        return Apiato::call(
            'Media@FindMediaPerEntityAndTypesTask',
            [
                $request->id,
                Community::class,
                [
                    'agenda',
                    'menu',
                    'exhibitors',
                    'location_map',
                ]
            ]
        );
    }
}
