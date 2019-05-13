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
use App\Containers\Media\UI\API\Requests\CreateMediaRequest;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class AddSponsorsToCommunityAction
 * @package App\Containers\Community\Actions
 */
class AddSponsorsToCommunityAction extends Action
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request)
    {
        $data = [
            'entity_id' => Hashids::encode($request->id),
            'entity_type' => Community::class,
            'type' => 'sponsor',
            'file' => $request->file,
        ];

        return Apiato::call('Media@CreateMediaAction', [new CreateMediaRequest($data)]);
    }
}
