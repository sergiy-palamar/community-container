<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\UI\API\Transformers;

use App\Containers\Community\Models\Community;
use App\Ship\Parents\Transformers\Transformer;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Containers\Invitation\UI\API\Transformers\InvitationTransformer;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Media\UI\API\Transformers\MediaTransformer;
use App\Containers\Speakers\UI\API\Transformers\SpeakersTransformer;

/**
 * Class CommunityTransformer
 * @package App\Containers\Community\UI\API\Transformers
 */
class CommunityTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [
        'admins',
        'invitations',
        'sponsors',
        'speakers',
        'attachments',
    ];

    /**
     * @param Community $entity
     *
     * @return array
     */
    public function transform(Community $entity)
    {
        $response = [
            'object' => 'Community',
            'id' => $entity->getHashedKey(),
            'status' => $entity->getStatus(),
            'title' => $entity->title,
            'description' => $entity->description,
            'id_code' => $entity->id_code,
            'address' => $entity->address,
            'forever_active' => (bool)$entity->forever_active,
            'start_date' => $entity->start_date,
            'end_date' => $entity->end_date,
            'created_at' => $entity->created_at,
            'updated_at' => $entity->updated_at,
            'avatar' => $entity->getAvatarLink(),
            'is_private' => (bool)$entity->is_private,
            'connection_date' => $entity->connection_date,
        ];

        $response = $this->ifAdmin([
            'real_id'    => $entity->id,
        ], $response);

        return $response;
    }

    /**
     * @param Community $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAdmins(Community $entity)
    {
        return $this->collection($entity->admins(), new UserTransformer());
    }

    /**
     * @param Community $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInvitations(Community $entity)
    {
        $invitations = Apiato::call('Invitation@FindInvitationsByCommunityIdTask', [$entity->id]);

        return $this->collection($invitations, new InvitationTransformer());
    }

    /**
     * @param Community $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSponsors(Community $entity)
    {
        return $this->collection($entity->sponsors(), new MediaTransformer());
    }

    /**
     * @param Community $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeSpeakers(Community $entity)
    {
        return $this->collection($entity->speakers(), new SpeakersTransformer());
    }

    /**
     * @param Community $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAttachments(Community $entity)
    {
        return $this->collection($entity->attachments(), new MediaTransformer());
    }
}
