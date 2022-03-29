<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;

class CommentController extends Controller
{
    /** @var CommentService $commentService */
    protected $commentService;

    /**
     * CommentController constructor.
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Fetch and list comments
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->commentService->getNestedComments();
    }

    /**
     * Store comment
     * @param StoreCommentRequest $request
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function store(StoreCommentRequest $request)
    {
        return $this->commentService->create($request->all());
    }
}
