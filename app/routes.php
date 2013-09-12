<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	//get most recent public lists
	$public_lists = Lizt::shared()->orderBy('updated_at', 'desc')->take(10)->get();

	$human_data = array();

	foreach ($public_lists as $list)
	{
		array_push($human_data, $list->getListInfo());
	}

	return Response::json(
		array
		(
			"status" => "success", 
			"data" => array("latest_lists" => $human_data)
		)
	);
});

Route::resource('account', 'UserController');
Route::resource('list', 'ListController');

if (Auth::check())
{
	Auth::logout();
}