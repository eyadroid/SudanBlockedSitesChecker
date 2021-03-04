<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ["name", "url"];


    function websiteRequests() {
        return $this->hasMany("App\Models\WebsiteRequest");
    }

    function lastRequest() {
        return $this->hasOne("App\Models\WebsiteRequest")->orderBy('created_at', 'desc');
    }

    function getWebsiteStatus() {
        if (config('env.debug')) {
            return [
                "avaliable" => true
            ];
        }
        $client = new Client();

        $response = $client -> request('POST',
            'http://localhost:3030',
            // 'http://eyadroid.ddns.net:3030',
            [
                'form_params' => [
                    "url" => $this->url
                ],
            ]
        );

        $data = json_decode($response -> getBody(), true);
        return [
            "avaliable" => $data["status"] == 200
        ];
    }
}
