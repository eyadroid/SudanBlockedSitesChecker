<?php

namespace Database\Seeders;

use App\Models\Website;
use App\Models\WebsiteRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $websites_blocked = [
        ["name"=> 'Paypal', "url"=> 'https://paypal.com', "approved" => 1],
        ["name"=> 'Google Cloud', "url"=> 'https://cloud.google.com', "approved" => 1],
        ["name"=> 'Firebase', "url"=> 'https://firebase.com', "approved" => 1],
        ["name"=> 'Nvedia', "url"=> 'https://nvidia.com', "approved" => 1],
    ];

    public function run()
    {
        Website::query()->delete();
        if (!config('env.debug'))
            foreach ($this->websites_blocked as $website) {
                Website::factory()
                ->state(
                    $website
                )
                ->has(WebsiteRequest::factory()->count(10))
                ->create();
            }
    }
}
