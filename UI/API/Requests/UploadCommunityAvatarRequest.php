<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use App\Containers\Community\Policy\UpdateCommunityPolicyInterface;

/**
 * Class UploadCommunityAvatarRequest
 * @package App\Containers\Community\UI\API\Requests
 */
class UploadCommunityAvatarRequest extends Request
{

    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => ['admin','community_admin'],
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

    private $updateCommunityPolicy;

    /**
     * UploadCommunityAvatarRequest constructor.
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
            'id' => 'required|exists:communities,id',
            'avatar' => 'required|max:10000|mimes:jpeg,gif,jpg,png'

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
