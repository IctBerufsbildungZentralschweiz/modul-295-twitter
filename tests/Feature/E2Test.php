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

        // Check if the query count is lower than 4
        // 4 is the number if all Tweet relationships are eager loaded, anything above is an N+1 problem.
        $this->assertLessThanOrEqual(
            4,
            $queryCount,
            'There is a N+1 problem present, too many queries are executed.'
        );
    }
}
