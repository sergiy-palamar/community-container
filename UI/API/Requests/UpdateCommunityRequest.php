<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use App\Containers\Community\Policy\UpdateCommunityPolicyInterface;

/**
 * Class UpdateCommunityRequest.
 */
class UpdateCommunityRequest extends Request
{

    /**
     * The assigned Transporter for this Request
     *
     * @var string
     */
    protected $transporter = \App\Containers\Community\Data\Transporters\UpdateCommunityTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => '',
        'roles' => ['admin', 'community_admin'],
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
     * @var UpdateCommunityPolicyInterface
     */
    private $updateCommunityPolicy;

    /**
     * UpdateCommunityRequest constructor.
     * @param UpdateCommunityPolicyInterface $updateCommunityPolicy
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(
        UpdateCommunityPolicyInterface $updateCommunityPolicy,
        array $query = array(),
        array $request = array(),
        array $attributes = array(),
        array $cookies = array(),
        array $files = array(),
        array $server = array(),
        $content = null
    ) {
        $this->updateCommunityPolicy = $updateCommunityPolicy;
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:1024',
            'id_code' => 'max:100',
            'address' => 'required|max:1024',
            'forever_active' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_private' => 'nullable|boolean',
            'connection_date' => 'nullable|date',
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check(['hasAccess',]) && $this->updateCommunityPolicy->execute($this);
    }
}
