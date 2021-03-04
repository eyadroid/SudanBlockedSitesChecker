<?php

namespace Tests\Admin;

use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;
use App\Models\Website;

class ApproveWebsiteTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');        
    }

    public function testApproveWebsite()
    {

        $pendingWebsite = Website::factory()->state([
            'approved' => 0
        ])->create();
        
        $response = $this->json('POST','api/admin/website/'.$pendingWebsite->id.'/approve');

        // check if no errors in request 
        $response->seeStatusCode(200);

        $this->seeInDatabase('websites', [
            "id" => $pendingWebsite->id,
            "approved" => 1
        ]);
    }
}
