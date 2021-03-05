<?php

namespace App\Http\Controllers\Admin;

use App\Models\Website;
use App\Http\Controllers\Controller;
use App\Models\WebsiteRequest;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    function pending() {
        $websites = Website::with('lastRequest')
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
        $url = $request->url;

        Website::create([
            "approved" => 1,
            "name" => $name,
            "url" => $url,
        ]);

        return response()->json([
            "success" => true,
            "data" => null,
            "message" => "Website Added Successfuly"
        ]);

    }

    function approve(int $website_id) {

        $website = Website::findOrFail($website_id);

        $website->approved = 1;

        $website->save();

        return response()->json([
            "success" => true,
            "data" => null,
            "message" => "Website Approved Successfuly"
        ]);
    }
    
    function edit(Request $request, int $website_id) {

        $this->validate($request, [
            "name" => "required|max:45|unique:websites,name,".$website_id,
            "url" => "required|url|unique:websites,url,".$website_id
        ]);

        $website = Website::findOrFail($website_id);

        $website->name = $request->name;
        $website->url = $request->url;

        $website->save();

        return response()->json([
            "success" => true,
            "data" => null,
            "message" => "Website Edited Successfuly"
        ]);
    }

}
