<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Community\Models\Community;
use App\Containers\Community\Exceptions\CommunityNotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Support\Facades\Storage;
use App\Containers\Community\Exceptions\CouldNotUploadAvatarException;

/**
 * Class AddCommunityAvatarAction
 * @package App\Containers\User\Actions
 */
class AddCommunityAvatarAction extends Action
{

    /**
     * @param $id
     * @param $avatar
     * @return Community
     */
    public function run($id, $avatar)
    {
        /**
         * @var $user Community
         */
        $community = Apiato::call('Community@FindCommunityByIdTask', [$id]);

        if (!$community) {
            throw new CommunityNotFoundException();
        }

        try {
            $file = Storage::put('public/avatars', $avatar);
            if (!$file) {
                throw new CouldNotUploadAvatarException();
            }

            if ($community->avatar) {
                try {
                    Storage::delete($community->avatar);
                } catch (\Exception $exception) {
                }
            }

            $communityData = [
                'avatar' =>$file,
            ];
            $communityData = array_filter($communityData);

            $community = Apiato::call('Community@UpdateCommunityTask', [$id, $communityData]);
        } catch (Exception $exception) {
            throw new CouldNotUploadAvatarException();
        }

        return $community;
    }
}
