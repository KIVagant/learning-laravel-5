<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function(){
	return 'Home Page';
});

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::resource('articles', 'ArticlesController');

Route::get('tags/{tags}', 'TagsController@show');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('foo', ['middleware' => 'manager', function(){
	return 'this page may only be viewed by managers';
}]);

/*
|--------------------------------------------------------------------------
| Dingo/api and Mitul/laravel-api-generator for Dingo
|--------------------------------------------------------------------------
*/
$api = app('api.router');

$api->group([
    'version' => 'v1',
    'prefix' => 'api',
    'namespace' => 'App\Http\Controllers\API',
], function ($api) {
    $api->resource('dingos', 'DingoAPIController');
    $api->get('{}errors/{id}', function($id) {
        return \Mitul\Generator\Errors::getErrors([$id]);
    });
    $api->get('errors', function() {
        return \Mitul\Generator\Errors::getErrors([], [], true);
    });
    $api->get('/', function() {
        $links = \App\Http\Controllers\API\DingoApiController::getHATEOAS();

        return ['links' => $links];
    });
});


Route::resource('dingos', 'DingoController');

Route::get('dingos/{id}/delete', [
    'as' => 'dingos.delete',
    'uses' => 'DingoController@destroy',
]);
