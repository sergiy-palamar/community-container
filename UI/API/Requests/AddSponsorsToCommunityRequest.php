<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class AddSponsorsToCommunityRequest
 * @package App\Containers\Community\UI\API\Requests
 */
class AddSponsorsToCommunityRequest extends Request
{

    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles' => ['admin', 'community_admin'],
    ];

    /**
     * @var array
     */
    protected $decode = [
        'id',
    ];

    /**
     * @var array
     */
    protected $urlParameters = [
        'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'file' => 'required|max:10000|mimes:jpeg,jpg,png',
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check(['hasAccess']);
    }
}
