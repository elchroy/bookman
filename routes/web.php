<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function (SimpleXMLElement $xml) use ($router) {
	$response = $xml->addChild('Welcome');
	$response->addChild('message', "Welcome to Bookman web service.");
	header('Content-type: text/xml');
	return ($xml->asXML());
});

$router->group(['prefix' => '/api/v1'], function () use ($router) {
    $router->post('/{serviceName}', "API\V1\SoapController@handle");
});
