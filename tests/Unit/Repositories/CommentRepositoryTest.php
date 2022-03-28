<?php

namespace Tests\Unit\Repositories;

use App\Models\Comment;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
        $this->wireUp();
    }

    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_can_create_a_comment()
    {
        $commentData = Comment::factory()->make();

        $comment = $this->commentRepository->create($commentData->toArray());

        $this->assertInstanceOf(Comment::class, $comment);
    }

    /**
     * @test
     */
    public function it_can_find_by_id()
    {
        $commentData = Comment::first();

        $comment = $this->commentRepository->findById($commentData->id);

        $this->assertEquals($commentData, $comment);
    }

    /**
     * @test
     */
    public function it_can_fetch_all()
    {
        $commentData = Comment::orderBy('id', 'DESC')->get();

        $comments = $this->commentRepository->getAll();

        $this->assertEquals($commentData, $comments);
        $this->assertEquals($commentData->count(), $comments->count());
    }

    /**
     * @test
     */
    public function it_can_fetch_by_criteria()
    {
        $commentData = Comment::where('id', 1)->get();

        $comments = $this->commentRepository->getByCriteria(['id' => 1]);

        $this->assertEquals($commentData, $comments);
        $this->assertEquals($commentData->count(), $comments->count());
    }

    /**
     * @test
     */
    public function it_can_update_a_comment()
    {
        $name = $this->faker->name();

        $data = ['user_name' => $name];

        $commentData = Comment::find(1);

        $comment = $this->commentRepository->update($commentData, $data);

        $this->assertEquals($name, $comment->user_name);
    }

    /**
     * @test
     */
    public function it_can_delete_a_comment()
    {
        $count = Comment::get()->count();

        $commentData = Comment::find(1);

        $this->commentRepository->delete($commentData);

        $comments = $this->commentRepository->getAll();

        $this->assertEquals(($count - 1), $comments->count());
    }
}
