<?php

class UserController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth.basic', array('except' => array('store')));
    }

	/**
	 * Display the account info (Use this for checking if auth works).
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();
		$user->rolls;

		return Response::json(
			array
			(
				"status" => "success", 
				"data" => array("user" => $user->toArray())
			)
		);
	}

	/**
	 * Show the first 10 lists from the user, you can add /2 for second page
	 *
	 * @return Response
	 */
	public function show($page)
	{
		$user = Auth::user();

		$lists = Roll::mostRecent($user, $page);

		$list_array = array();

		foreach ($lists as $list)
		{
			array_push($list_array, $list->toArray());
		}

		return Response::json(
				array
				(
					"status" => "success", 
					"lists" => $list_array
				)
			, 409);
	}

	/**
	 * Register a new user with this resource. Accepts username/password
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User;

		$user->username = Input::get("username");
		$user->password = Input::get("password"); //hash this password later

		$status = $user->validate();

		if (!$status) 
		{
			return Response::json(
				array
				(
					"status" => "error", 
					"data" => $user->getErrors()
				)
			, 409);
		}
		else
		{
			$user->password = Hash::make($user->password);
			$user->save();

			return Response::json(
				array
				(
					"status" => "success", 
					"data" => "User Account has been created!"
				)
			, 201);
		}
	}

}