<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommunityNotFoundException
 * @package App\Containers\User\Exceptions
 */
class CommunityNotAvailableToConnectException extends Exception
{

    public $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Connection to the event will be available from connection_date.';
}
