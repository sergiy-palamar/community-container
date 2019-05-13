<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Providers;

use App\Ship\Parents\Providers\MainProvider;
use App\Containers\Community\Policy\UpdateCommunityPolicy;
use App\Containers\Community\Policy\UpdateCommunityPolicyInterface;

/**
* Class MainServiceProvider.
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{

    /**
     * Container Service Providers.
     *
     * @var array
     */
    public $serviceProviders = [];

    /**
     * Container Aliases
     *
     * @var  array
     */
    public $aliases = [];

    /**
     * Register anything in the container.
     */
    public function register()
    {
        parent::register();
        $this->app->bind(UpdateCommunityPolicyInterface::class, UpdateCommunityPolicy::class);
    }
}
