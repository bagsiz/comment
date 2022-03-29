<?php

namespace App\Services;

class CommentService extends BaseService
{

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * Created Comments
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function create(array $request)
    {
        return $this->commentRepository->create($request);
    }

    /**
     * Fetch Nested Comments
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNestedComments(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->commentRepository->getByCriteria(['parent_id' => 0], ['*']);
    }
}
