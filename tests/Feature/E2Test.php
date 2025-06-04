<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class E2Test extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_there_is_no_n1_problem()
    {
        DB::enableQueryLog();

        $this->getJson('/api/tweets');

        $queryCount = count(DB::getQueryLog());

        $hasLikedTweets = method_exists(\App\Models\User::class, 'likedTweets');

        // Assert query count based on the presence of the `liked_tweets` relationship
        $this->assertEquals(
            $hasLikedTweets ? 4 : 3,
            $queryCount,
            'There is a N+1 problem present, too many queries are executed.'
        );
    }
}
