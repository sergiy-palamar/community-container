<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Models;

use App\Ship\Parents\Models\Model;
use App\Containers\User\Models\User;
use App\Containers\Invitation\Models\Invitation;
use App\Contract\RoleInterface;

use Apiato\Core\Foundation\Facades\Apiato;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use App\Containers\Speakers\Models\Speakers;

/**
 * Class Community
 * @package App\Containers\Community\Models
 */
class Community extends Model
{

    /**
     * value for not active status
     * @var string
     */
    public const NOT_ACTIVE_STATUS = "not_active";

    /**
     * value for active status
     * @var string
     */
    public const ACTIVE_STATUS = "active";

    /**
     * Community status will be valid per each customer
     * @var string
     */
    public $status = Community::ACTIVE_STATUS;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'communities';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'avatar',
        'verification_code',
        'id_code',
        'address',
        'forever_active',
        'is_private',
        'start_date',
        'end_date',
        'connection_date',
    ];

    /**
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * @var array
     */
    protected $casts = [
        'forever_active' => 'boolean',
        'is_private' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'connection_date',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected $resourceKey = 'communities';

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_community');
    }

    /**
     * @return HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'community_invitations');
    }

    /**
     * @param $userId
     * @return bool
     */
    public function hasUser($userId): bool
    {
        $users = $this->users()->get();
        foreach ($users as $user) {
            if ($user->id == $userId) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        $userLogged = auth('api')->user();
        if (!$userLogged->is(RoleInterface::ADMIN_ROLE_NAME)) {
            $isActive = Apiato::call('Community@IsCommunityActiveForUserTask', [$userLogged, $this]);
            if (!$isActive) {
                $this->setStatus(Community::NOT_ACTIVE_STATUS);
            }
        }

        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins()
    {
        $admins = Apiato::call('Community@FindCommunityAdminsTask', [$this->id]);
        return collect($admins);
    }

    /**
     * Return url to community avatar
     *
     * @return string
     */
    public function getAvatarLink()
    {
        $avatarUrl = "";
        if ($this->avatar) {
            $avatarUrl = url('/') . Storage::url($this->avatar);
        }
        return $avatarUrl;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sponsors()
    {
        return Apiato::call(
            'Media@NoPaginationFindMediaPerEntityAndTypesTask',
            [
                $this->id,
                self::class,
                [
                    'sponsor'
                ]
            ]
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return Apiato::call(
            'Media@NoPaginationFindMediaPerEntityAndTypesTask',
            [
                $this->id,
                self::class,
                [
                    'agenda',
                    'menu',
                    'exhibitors',
                    'location_map',
                ]
            ]
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function speakers()
    {
        return $this->hasMany(Speakers::class)->get();
    }
}
