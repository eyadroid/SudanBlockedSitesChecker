<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;
use App\Models\Website;

class GetWebsitesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');        
    }

    public function testGetAllWebsites()
    {
        $response = $this->json('GET','api/all');

        // check if no errors in request 
        $response->seeStatusCode(200);

        // TO DO: test response websites sizes
    }
}
