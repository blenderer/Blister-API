<?php

class RollController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth.basic', array('only' => array('destroy', 'show', 'store', 'update', 'index')));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show a resource in storage.
	 *
	 * @param id
	 * @return Response
	 */
	public function show($identifier)
	{
		$list = Roll::findOrFail($identifier);

		$list->user; //call this so it gets displayed
		$list->items;

		if ($list->public) //if its public, get it.
		{
			return Response::json(
				array
				(
					"status" => "success", 
					"data" => array("list" => $list->toArray())
				)
			);
		}
		else //else authenticate user
		{
			if ($list->user == Auth::user())
			{
				return Response::json(
					array
					(
						"status" => "success", 
						"data" => array("list" => $list->toArray())
					)
				);
			}
			else
			{
				return Response::json(
					array
					(
						"status" => "fail", 
						"data" => "Attempting to access a private list."
					)
					, 401);
			}
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$list = new Roll;

		$list->name = Input::get("name");
		$list->public = Input::get("public");
		$list->user_id = Auth::user()->id;

		$status = $list->validate();

		if (!$status) 
		{
			return Response::json(
				array
				(
					"status" => "error", 
					"data" => $list->getErrors()
				)
			, 409);
		}
		else
		{
			$list->save();

			return Response::json(
				array
				(
					"status" => "success", 
					"data" => "New list has been created!"
				)
			, 201);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$list = Roll::findOrFail($id);

		if ($list->user == Auth::user())
		{
			$list->name = Input::get('name');
			$list->public = Input::get('public');
			$list->user_id = Auth::user()->id;
			
			$status = $list->validate();

			if (!$status) 
			{
				return Response::json(
					array
					(
						"status" => "error", 
						"data" => $list->getErrors()
					)
				, 409);
			}
			else 
			{
				$list->save();

				return Response::json(
					array
					(
						"status" => "success", 
						"data" => "List has been updated!"
					)
				, 201);
			}
		}
		else
		{
			return Response::json(
				array
				(
					"status" => "error", 
					"data" => "Cannot update that user's list, it's not yours."
				)
			, 401);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$list = Roll::findOrFail($id);

		if ($list->user == Auth::user())
		{
			$list->delete();

			return Response::json(
				array
				(
					"status" => "success", 
					"data" => "List has been deleted!"
				)
			, 201);
		}
		else
		{
			return Response::json(
				array
				(
					"status" => "error", 
					"data" => "Cannot delete that user's list, it's not yours."
				)
			, 401);
		}
	}

}