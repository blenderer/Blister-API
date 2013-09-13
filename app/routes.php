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
	$page = 1;
	//get most recent public lists (non-functional till I make a decision)
	//I will make $page a url parameter instead of a route
	if ($page == "")
		$page = 1;

	$page = $page - 1;
	$public_lists = Lizt::shared()->orderBy('updated_at', 'desc')->skip($page * 10)->take(10)->get();

	$human_data = array();

	foreach ($public_lists as $list)
	{
		array_push($human_data, $list->getListData(array("name" => 1, "id" => 1, "item_count" => 1, "public" => 0, "username" => 1)));
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