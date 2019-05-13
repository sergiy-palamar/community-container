<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Controllers;

use App\Containers\Community\UI\API\Requests\CreateCommunityRequest;
use App\Containers\Community\UI\API\Requests\DeleteCommunityRequest;
use App\Containers\Community\UI\API\Requests\GetAllCommunitiesRequest;
use App\Containers\Community\UI\API\Requests\FindCommunityByIdRequest;
use App\Containers\Community\UI\API\Requests\UpdateCommunityRequest;
use App\Containers\Community\UI\API\Requests\FindCommunityUsersRequest;
use App\Containers\Community\UI\API\Requests\FindCommunityAdminsRequest;
use App\Containers\Community\UI\API\Requests\UploadCommunityAvatarRequest;
use App\Containers\Community\UI\API\Requests\AddAttachmentsToCommunityRequest;
use App\Containers\Community\UI\API\Requests\GetAttachmentsPerCommunityRequest;
use App\Containers\Community\UI\API\Requests\AddSponsorsToCommunityRequest;
use App\Containers\Community\UI\API\Transformers\CommunityTransformer;
use App\Containers\Media\UI\API\Transformers\MediaTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Apiato\Core\Foundation\Facades\Apiato;

use App\Containers\User\UI\API\Transformers\UserTransformer;

/**
 * Class Controller
 *
 * @package App\Containers\Community\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateCommunityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCommunity(CreateCommunityRequest $request)
    {
        $community = Apiato::call('Community@CreateCommunityAction', [$request]);

        return $this->created($this->transform($community, CommunityTransformer::class));
    }

    /**
     * @param FindCommunityByIdRequest $request
     * @return array
     */
    public function findCommunityById(FindCommunityByIdRequest $request)
    {
        $community = Apiato::call('Community@FindCommunityByIdAction', [$request]);

        return $this->transform($community, CommunityTransformer::class);
    }

    /**
     * @param GetAllCommunitiesRequest $request
     * @return array
     */
    public function getAllCommunities(GetAllCommunitiesRequest $request)
    {
        $communities = Apiato::call('Community@GetAllCommunitiesAction', [$request]);

        return $this->transform($communities, CommunityTransformer::class);
    }

    /**
     * @param UpdateCommunityRequest $request
     * @return array
     */
    public function updateCommunity(UpdateCommunityRequest $request)
    {
        $community = Apiato::call('Community@UpdateCommunityAction', [$request]);

        return $this->transform($community, CommunityTransformer::class);
    }

    /**
     * @param DeleteCommunityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCommunity(DeleteCommunityRequest $request)
    {
        Apiato::call('Community@DeleteCommunityAction', [$request]);

        return $this->noContent();
    }

    /**
     * @param FindCommunityUsersRequest $request
     * @return array
     */
    public function findCommunityUsers(FindCommunityUsersRequest $request)
    {
        $users = Apiato::call('Community@FindCommunityUsersAction', [$request]);

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param FindCommunityAdminsRequest $request
     * @return array
     */
    public function findCommunityAdmins(FindCommunityAdminsRequest $request)
    {
        $users = Apiato::call('Community@FindCommunityAdminsAction', [$request]);

        return $this->transform($users, UserTransformer::class);
    }

    /**
     * @param UploadCommunityAvatarRequest $request
     * @return array
     */
    public function uploadCommunityAvatar(UploadCommunityAvatarRequest $request)
    {
        $community = Apiato::call('Community@AddCommunityAvatarAction', [$request->id, $request->avatar]);

        return $this->transform($community, CommunityTransformer::class);
    }

    /**
     * @param AddAttachmentsToCommunityRequest $request
     * @return array
     */
    public function addAttachmentsToCommunity(AddAttachmentsToCommunityRequest $request)
    {
        $media = Apiato::call('Community@AddAttachmentsToCommunityAction', [$request]);

        return $this->transform($media, MediaTransformer::class);
    }

    /**
     * @param GetAttachmentsPerCommunityRequest $request
     * @return array
     */
    public function getAttachmentsPerCommunity(GetAttachmentsPerCommunityRequest $request)
    {
        $attachments = Apiato::call('Community@GetAttachmentsPerCommunityAction', [$request]);

        return $this->transform($attachments, MediaTransformer::class);
    }

    /**
     * @param AddSponsorsToCommunityRequest $request
     * @return array
     */
    public function addSponsorsToCommunity(AddSponsorsToCommunityRequest $request)
    {
        $request->request->add(['type' => 'sponsor']);
        $media = Apiato::call('Community@AddSponsorsToCommunityAction', [$request]);

        return $this->transform($media, MediaTransformer::class);
    }

    /**
     * @param GetAttachmentsPerCommunityRequest $request
     * @return array
     */
    public function getSponsorsPerCommunity(GetAttachmentsPerCommunityRequest $request)
    {
        $attachments = Apiato::call('Community@GetSponsorsPerCommunityAction', [$request]);

        return $this->transform($attachments, MediaTransformer::class);
    }

}
