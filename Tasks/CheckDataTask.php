<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Containers\Community\Models\Community;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use App\Containers\User\Models\User;
use Apiato\Core\Foundation\Facades\Apiato;
use Illuminate\Support\Carbon;

/**
 * Class CheckDataTask
 * @package App\Containers\Community\Tasks
 */
class CheckDataTask extends Task
{

    /**
     * @param $checkIn
     * @param $checkOut
     * @return bool
     */
    public function run($checkIn, $checkOut): bool
    {
        try {
            $checkIn = date_timestamp_get($checkIn);
            $checkOut = date_timestamp_get($checkOut);
            $current = date_timestamp_get(new \DateTime('now'));

            return ($checkIn <= $current && $current <= $checkOut) || ($current <= $checkIn);
        } catch (Exception $exception) {
        }

        return false;
    }
}
