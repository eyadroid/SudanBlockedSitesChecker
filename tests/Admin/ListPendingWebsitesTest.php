<?php

namespace Tests\Admin;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;
use App\Models\Website;

class ListPendingWebsitesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');        
    }

    public function testGetPendingWebsites()
    {
        $numberOfPendingProducts = 7;
        $numberOfApprovedProducts = 4;

        Website::factory()->count($numberOfPendingProducts)->state([
            'approved' => 0
        ])->create();
        Website::factory()->count($numberOfApprovedProducts)->state([
            'approved' => 1
        ])->create();
        
        $response = $this->json('GET','api/admin/pending');

        // check if no errors in request 
        $response->seeStatusCode(200);

        // TO DO: test response websites sizes
    }
}
