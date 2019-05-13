<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CouldNotUploadAvatarException
 * @package App\Containers\Community\Exceptions
 */
class CouldNotUploadAvatarException extends Exception
{

    public $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Some problem with uploading file.';
}