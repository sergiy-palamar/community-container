<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class DeleteCommunityRequest.
 */
class DeleteCommunityRequest extends Request
{

    /**
     * The assigned Transporter for this Request
     *
     * @var string
     */
    protected $transporter = \App\Containers\Community\Data\Transporters\DeleteCommunityTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => 'admin',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
         'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
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
