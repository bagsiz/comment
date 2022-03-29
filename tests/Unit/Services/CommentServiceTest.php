<?php

namespace Tests\Unit\Services;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryContract;
use App\Services\CommentService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CommentServiceTest extends TestCase
{
    /** @var CommentService $commentService */
    protected $commentService;

    /** @var CommentRepositoryContract|\Mockery\LegacyMockInterface|\Mockery\MockInterface $commentRepository */
    protected $commentRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
        $this->wireUp();

        $this->commentRepository = \Mockery::mock(CommentRepositoryContract::class);
        $this->commentService = new CommentService($this->commentRepository);

    }

    public function tearDown(): void
    {
        $this->resetDatabase();
        \Mockery::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_tests_create_a_comment_by_service()
    {
        $commentData = [
            'comment' => $this->faker->text(),
            'user_name' => $this->faker->name(),
            'parent_id' => 0,
        ];

        $this->commentRepository->shouldReceive('create')
            ->with($commentData)
            ->once()->andReturn(Comment::hydrate([$commentData])->first());

        $resp = $this->commentService->create($commentData);

        $this->assertInstanceOf(Comment::class, $resp);
    }


    /**
     * @test
     */
    public function it_tests_get_nested_comments_by_service()
    {

        $this->commentRepository->shouldReceive('getByCriteria')
            ->with(['parent_id' => 0], ['*'])
            ->once()->andReturn(Comment::factory()->count(5)->make());

        $resp = $this->commentService->getNestedComments();

        $this->assertInstanceOf(Collection::class, $resp);
        $this->assertInstanceOf(Comment::class, $resp->first());
    }


}
