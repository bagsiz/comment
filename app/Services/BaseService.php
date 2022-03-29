<?php

namespace App\Services;

use App\Repositories\Contracts\CommentRepositoryContract;

abstract class BaseService
{
    /** @var CommentRepositoryContract $commentRepository */
    protected $commentRepository;

    /**
     * BaseService constructor.
     * @param CommentRepositoryContract $commentRepository
     */
    public function __construct(
        CommentRepositoryContract $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return mixed
     */
    abstract public function getAll();

    /**
     * @param array $request
     * @return mixed
     */
    abstract public function create(array $request);
}
