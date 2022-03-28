<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryContract;

class CommentRepository extends BaseRepository implements CommentRepositoryContract
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
