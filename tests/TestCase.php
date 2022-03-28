<?php

namespace Tests;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var CommentRepository $commentRepository */
    protected $commentRepository;

    protected $faker;

    protected function initDatabase()
    {

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    protected function resetDatabase()
    {
        Artisan::call('migrate:reset');
    }

    protected function wireUp()
    {
        $this->commentRepository = new CommentRepository(new Comment());
        $this->faker = Factory::create();
    }

}
