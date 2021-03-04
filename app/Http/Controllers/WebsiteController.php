<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Http\Controllers\Controller;
use App\Models\WebsiteRequest;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    function all(Request $request) {
        $websites = Website::where("approved", 1)
            ->with('lastRequest')
            ->orderBy("created_at")
            ->get();

        return response()->json([
            "success" => true,
            "data" => [
                "websites" => $websites
            ],
            "message" => ""
        ]);
    }

    function add(Request $request) {
        $this->validate($request, [
            "name" => "required|max:45|unique:websites",
            "url" => "required|url|unique:websites"
        ]);

        $name = $request->name;
        $url = $request->name;

        Website::create([
            "name" => $name,
            "url" => $url,
        ]);

        return response()->json([
            "success" => true,
            "data" => null,
            "message" => "Website Added Successfuly"
        ]);

    }

    function checkStatus(int $website_id) {

        $website = Website::findOrFail($website_id);

        $now = Carbon::now();
        $beforeMinute = Carbon::now()->subMinutes(1);

        $lastRequestsWithinMinute = WebsiteRequest::where('created_at', '>=', $beforeMinute)
        ->where('created_at', '<=', $now)
        ->orderBy("created_at")
        ->get();

        if ($lastRequestsWithinMinute->count() >= 10) {
            return response()->json([
                "success" => true,
                "data" => [
                    "lastRequest" => $lastRequestsWithinMinute[0]
                ],
                "message" => ""
            ]);
        }
        else {
            try {
                $website_status = $website->getWebsiteStatus()['avaliable'];
                $checkingRequest = WebsiteRequest::create([
                    "website_id" => $website_id,
                    "available" => $website_status
                ]);
        
                return response()->json([
                    "success" => true,
                    "data" => [
                        "lastRequest" => $checkingRequest
                    ],
                    "message" => ""
                ]);
            }
            catch(ConnectException $e) {
                return response()->json([
                    "success" => false,
                    "data" => null,
                    "message" => "Couldn't check the website status right now :("
                ]);
            }
        }

    }

}
