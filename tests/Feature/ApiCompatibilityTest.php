<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCompatibilityTest extends TestCase
{
    public function test_home_api_endpoint()
    {
        $response = $this->get('/api/home');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'home_slider',
            'categories',
            'new_products'
        ]);
    }

    public function test_category_api_endpoint()
    {
        $response = $this->get('/api/category');
        $response->assertStatus(200);
    }
}
