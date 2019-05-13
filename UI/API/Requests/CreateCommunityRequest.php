<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class CreateCommunityRequest.
 */
class CreateCommunityRequest extends Request
{

    /**
     * The assigned Transporter for this Request
     * @var string
     */
    protected $transporter = \App\Containers\Community\Data\Transporters\CreateCommunityTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     * @var  array
     */
    protected $access = [
        'permissions' => '',
        'roles' => ['admin', 'community_admin'],
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     * @var  array
     */
    protected $decode = [
        // 'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     * @var  array
     */
    protected $urlParameters = [
        // 'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:1024',
            'id_code' => 'nullable|max:100|unique:communities,id_code',
            'address' => 'required|max:1024',
            'forever_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'connection_date' => 'nullable|date',
            'is_private' => 'nullable|boolean',
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check(['hasAccess']);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            "id_code.unique" => "Event ID is already taken",
        ];
    }
}
