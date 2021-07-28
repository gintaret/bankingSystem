<?php

namespace Tests\Unit;

use Tests\TestCase;

class CheckPathTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/transfer');
        $response->assertStatus(200);
    }
}
