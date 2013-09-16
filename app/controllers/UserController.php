<?php

class UserController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth.basic', array('only' => array('index', 'destroy', 'show')));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(
			array
			(
				"status" => "success", 
				"data" => array("user" => Auth::user()->toArray())
			)
		);
	}

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
	 * Store a newly created resource in storage.
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