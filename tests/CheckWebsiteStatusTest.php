<?php

namespace Tests;

use App\Models\Website;
use App\Models\WebsiteRequest;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CheckWebsiteStatusTest extends TestCase
{
    use DatabaseMigrations;

    private $check_website_route;
    private $theWebsite;

    public function setUp(): void
    {
        parent::setUp();
        $this->theWebsite = Website::create([
            "name" => "paypal",
            "url" => "https://paypal.com",
        ]);
        $this->check_website_route = 'api/website/'.$this->theWebsite->id.'/check-status';
    }

    
    public function testWillCreateNewRequestWhenThereIsNo10PerviousRequestsWithinMinute()
    {
        $response = $this->json("POST",$this->check_website_route);

        // check if no errors in request 
        $response->seeStatusCode(200);

        $this->assertCount(1, $this->theWebsite->websiteRequests);
    }
    
    public function testWillReturnLastRequestWhenThereIs10PerviousRequestsWithinMinute()
    {        
        $now = Carbon::now();
        WebsiteRequest::factory()
        ->count(10)
        ->state([
            "website_id" => $this->theWebsite->id,
            "created_at" => $now
        ])
        ->create();

        $response = $this->json("POST", $this->check_website_route);

        // check if no errors in request 
        $response->seeStatusCode(200);

        $this->assertCount(10, $this->theWebsite->websiteRequests);
    }
}
