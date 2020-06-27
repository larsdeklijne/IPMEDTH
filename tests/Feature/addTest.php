<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class addTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('GET', '/patient/index?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6OD
        AwMFwvYXBpXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1OTMyOTQ2NzEsImV4cCI6MTU5MzI5ODI3MSwibmJmIjoxNTkzMjk0NjcxLCJqdGkiOiJERmQyTDVreXQ2OXFRcXNlIiwic
        3ViIjoyLCJwcnYiOiIxNjUwMGEyZWJhYzhkNjAxODE5ZjkxZjU0ZTRlZGQxYTZjMjRiZTRmIn0.AmC6yYEoi5Kk8jURiB27s7mWjC43qqGQuxlCgQPL_Es');

        $this->assertEquals(200, $response->status());
    }
}
