<?php

class UserController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth.basic', array('only' => array('index', 'destroy')));
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