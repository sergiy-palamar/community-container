<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class CommunityRepository
 * @package App\Containers\Community\Data\Repositories
 */
class CommunityRepository extends Repository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'                => '=',
        'verification_code' => '=',
        'id_code'           => '=',
        'forever_active'    => '=',
        'is_private'    => '=',
        'title'             => 'like',
        'description'       => 'like',
        'created_at'        => 'like',
        'address'           => 'like',
    ];
}
