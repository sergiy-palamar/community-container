<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Ship\Parents\Tasks\Task;
use App\Containers\Community\Exceptions\CommunityNotAvailableToConnectException;

/**
 * Class IsAvailableToConnectTask
 * @package App\Containers\Community\Tasks
 */
class IsAvailableToConnectTask extends Task
{

    /**
     * @param $connectData
     * @return bool
     */
    public function run($connectData): bool
    {
        if ($connectData) {
            $connectDataTime = date_timestamp_get($connectData);
            $current = date_timestamp_get(new \DateTime('now'));

            $message = str_replace(
                "connection_date",
                (new \DateTime($connectData))->format("Y-m-d h:m:i"),
                (new CommunityNotAvailableToConnectException())->getMessage()
            );
            if ($connectDataTime > $current) {
                throw new CommunityNotAvailableToConnectException($message);
            }
        }

        return true;
    }
}
