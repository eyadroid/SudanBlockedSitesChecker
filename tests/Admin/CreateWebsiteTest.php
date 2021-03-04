<?php

namespace Tests\Admin;

use App\Models\Website;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class CreateWebsiteTest extends TestCase
{
    use DatabaseMigrations;
    
    private $add_website_url = 'api/admin/website/create';
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');        
    }

    public function testWebsiteNameAndUrlIsRequired()
    {

        $response = $this->json('POST', $this->add_website_url);

        // assert there is errors 
        $response->seeJsonStructure([
            "name",
            "url"
        ])->seeStatusCode(422);

    }
    
    public function testWebsiteNameAndUrlMustBeUnique()
    {
        $webisteWithSameInformations = Website::first();
        $response = $this->json('POST', $this->add_website_url, [
            "name" => $webisteWithSameInformations->name,
            "url" => $webisteWithSameInformations->url
        ]);

        // assert there is errors 
        $response->seeJsonStructure([
            "name",
            "url"
        ])->seeStatusCode(422);

    }
    
    public function testAddingAWebsite()
    {

        $response = $this->json("POST",$this->add_website_url, [
            "name" => "ty-hamadok",
            "url" => "http://ty-hamadok.org"
        ]);

        // check if no errors in request 
        $response->seeStatusCode(200)
        ->seeJsonContains(["success"=> true]);

        // check if it get all websites
        $this->seeInDatabase('websites', ['name' => "ty-hamadok"]);
    }
}
