<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('短網址產生器');

        $response = $this->call('POST', '/', ['url' => 'https://wwwg.oogle.com']);

        $response->assertStatus(200);

        $response->assertSee('分析');
    }
}
