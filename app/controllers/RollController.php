<?php

class RollController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth');
    }

	/**
	 * Show a List and it's list items.
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
	 * Store a newly created list in storage. Accepts name/public
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
	 * Update the list specified
	 * Accepts name/public and list item order like this:
	 * 4,2,1,3
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$list = Roll::findOrFail($id);

		if ($list->user == Auth::user())
		{

			if ($name = Input::get('name'))
			{
				$list->name = $name;
			}
			if ($public = Input::get('public'))
			{
				$list->public = $public;
			}
			
			$status = $list->validate();

			if ($order = Input::get('order'))
			{


				$order = explode(",", $order);

				if (count($order) == $list->itemCount())
				{
					$list->changeItemOrder($order);
				}
				else
				{
					return Response::json(
						array
						(
							"status" => "fail", 
							"data" => "Updated List count does not match saved List."
						)
					, 401);
						}
				
			}

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
				//so we can show the user the list items after
				$list->items;

				return Response::json(
					array
					(
						"status" => "success", 
						"data" => "List has been updated."
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
	 * Remove the specified list from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$list = Roll::findOrFail($id);

		if ($list->user == Auth::user())
		{
			$list->items()->delete();
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