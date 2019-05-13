<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class FindCommunityByIdRequest
 * @package App\Containers\Community\UI\API\Requests
 */
class FindCommunityByIdRequest extends Request
{
    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => '',
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
            'id' => 'required|exists:communities,id'
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
