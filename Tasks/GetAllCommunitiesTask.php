<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

namespace App\Containers\Community\Tasks;

use App\Containers\Community\Data\Repositories\CommunityRepository;
use App\Ship\Parents\Tasks\Task;
use App\Containers\Community\Data\Criterias\AdminsCriteria;
use App\Containers\Community\Data\Criterias\MemberCriteria;
use App\Containers\Community\Data\Criterias\CommunityCriteria;
use App\Containers\Community\Data\Criterias\CommunityAdminCriteria;
use App\Containers\Community\Data\Criterias\PrivateCommunityCriteria;
use Illuminate\Http\Request;

/**
 * Class GetAllCommunitiesTask
 * @package App\Containers\Community\Tasks
 */
class GetAllCommunitiesTask extends Task
{

    /**
     * @var CommunityRepository
     */
    protected $repository;

    /**
     * @var Request
     */
    protected $request;

    /**
     * GetAllCommunitiesTask constructor.
     * @param CommunityRepository $repository
     * @param Request $request
     */
    public function __construct(
        CommunityRepository $repository,
        Request $request
    ) {
        $this->repository = $repository;
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        return $this->repository
            ->orderBy('communities.id', 'desc')
            ->paginate(null, ['communities.*']);
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function admins()
    {
        $this->repository->pushCriteria(new AdminsCriteria($this->request));
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function community()
    {
        $this->repository->pushCriteria(new CommunityCriteria($this->request));
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function member()
    {
        $this->repository->pushCriteria(new MemberCriteria($this->request));
    }

    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function private()
    {
        $this->repository->pushCriteria(new PrivateCommunityCriteria($this->request));
    }


    /**
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function communityAdmin()
    {
        $this->repository->pushCriteria(new CommunityAdminCriteria($this->request));
    }

}
