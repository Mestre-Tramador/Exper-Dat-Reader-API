<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| WEB Routes
|--------------------------------------------------------------------------
*/
$router->get('/', function () use ($router) {
    // TODO: Create redirect to Frontend.
    return $router->app->version();
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'dat'], function () use ($router) {
        // ? Dump and Processed Data Routes
        $router->get('done', 'DoneDatController@getDump');

        // ? Util Routes
        $router->get('total', 'DatController@countDats');
    });
});
