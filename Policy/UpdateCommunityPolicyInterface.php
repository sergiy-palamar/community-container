<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Policy;

use App\Ship\Parents\Requests\Request;

/**
 * Interface UpdateCommunityPolicyInterface
 * @package App\Containers\Community\Policy
 */
interface UpdateCommunityPolicyInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function execute(Request $request): bool;
}
