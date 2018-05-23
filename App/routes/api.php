<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->get('/', [\App\Controllers\PagesController::class, 'getHome']);
$app->get('/search', [\App\Controllers\SearchController::class, 'getSearch']);
$app->add(new \App\Middlewares\CorsMiddleware());