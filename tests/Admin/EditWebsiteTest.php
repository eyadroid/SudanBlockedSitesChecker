<?php

namespace Tests\Admin;

use App\Models\Website;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class EditWebsiteTest extends TestCase
{
    use DatabaseMigrations;
    
    private $edit_website_url;
    private $theWebsite;
    private $anotherWebsite;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');        
        $this->theWebsite = Website::create([
            "name" => "testEditing",
            "url" => "https://testEditing.com",
        ]);
        $this->anotherWebsite = Website::create([
            "name" => "anotherWebsite",
            "url" => "https://anotherWebsite.com",
        ]);
        $this->edit_website_url = 'api/admin/website/'.$this->theWebsite->id.'/edit';

    }

    public function testWebsiteNameAndUrlIsRequired()
    {
        $response = $this->json('POST', $this->edit_website_url);

        // assert there is errors 
        $response->seeJsonStructure([
            "name",
            "url"
        ])->seeStatusCode(422);

    }
    
    public function testWebsiteNameAndUrlMustBeUnique()
    {
        $response = $this->json('POST', $this->edit_website_url, [
            "name" => $this->anotherWebsite->name,
            "url" => $this->anotherWebsite->url
        ]);

        // assert there is errors 
        $response->seeJsonStructure([
            "name",
            "url"
        ])->seeStatusCode(422);

    }
    
    public function testEditingWebsite()
    {

        $response = $this->json("POST",$this->edit_website_url, [
            "name" => "ty-hamadok",
            "url" => $this->theWebsite->url
        ]);

        // check if no errors in request 
        $response->seeStatusCode(200)
        ->seeJsonContains(["success"=> true]);

        // check if it get all websites
        $this->seeInDatabase('websites', ['name' => "ty-hamadok"]);
    }
}
