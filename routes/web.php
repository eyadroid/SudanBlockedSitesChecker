<?php

$router->group(['prefix' => 'api'], function() use ($router) {

    $router->get("all", "WebsiteController@all");
    $router->post("add", "WebsiteController@add");
    $router->post("website/{website_id}/check-status", "WebsiteController@checkStatus");

    $router->group(['prefix' => 'admin'], function() use ($router) {
        
        $router->get("pending", "Admin\WebsiteController@pending");
        $router->post("website/create", "Admin\WebsiteController@add");
        $router->post("website/{website_id}/approve", "Admin\WebsiteController@approve");
        $router->post("website/{website_id}/edit", "Admin\WebsiteController@edit");
        
    });

});

$router->get('/', function ()  {
    return view('app');
});