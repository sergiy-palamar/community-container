<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Containers\User\Models\User;

/**
 * Class CommunitiesCountTransformer
 * @package App\Containers\Community\UI\API\Transformers
 */
class CommunitiesCountTransformer extends Transformer
{

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {

        /**
         * @var $communities \Illuminate\Database\Eloquent\Collection
         */
        $communities = $user->community()->get();

        $response = [
            'communities_count' => $communities->count()
        ];

        return $response;
    }
}
