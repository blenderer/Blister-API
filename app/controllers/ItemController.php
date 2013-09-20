<?php

class ItemController extends \BaseController {

	function __construct() {
        $this->beforeFilter('auth.basic');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//YOU GET NOTHING, GOOD DAY SIR.
	}

	/**
	 * Show a resource in storage.
	 *
	 * @param id
	 * @return Response
	 */
	public function show($id)
	{
		$listitem = Item::findOrFail($id);

		if ($listitem->roll->user->username == Auth::user()->username)
		{
			return Response::json(
				array
				(
					"status" => "success", 
					"data" => $listitem->toArray()
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Need- roll_id, item_text

		if (Input::has('roll_id', 'item_text'))
		{
			$item = new Item();

			$item->roll_id = Input::get("roll_id");
			$item->item_text = Input::get("item_text");

			if (Auth::user()->id == $item->roll_id)
			{
				$item->order = $item->roll->topOrder() + 1;
				$item->save();
				return Response::json(
					array
					(
						"status" => "success", 
						"data" => $item->toArray()
					)
					);
			}
			else
			{
				return Response::json(
					array
					(
						"status" => "fail", 
						"data" => "Attempting to add items a private list."
					)
					, 401);
			}
		}
		else
		{
			return Response::json(
					array
					(
						"status" => "fail", 
						"data" => "Need to POST roll_id and item_text."
					)
					, 401);
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
		$item = Item::findOrFail($id);

		if ($item->roll->user == Auth::user())
		{
			//Need- checked and item_text
			if ($checked = Input::get('checked'))
			{
				if ($checked == 1 || $checked == 0)
					$item->checked = $checked;
			}
			if ($item_text = Input::get('item_text'))
			{
				$item->item_text = $item_text;
			}

			$item->save();
			return Response::json(
				array
				(
					"status" => "success", 
					"data" => "Item has been updated successfully."
				)
				);
		}
		else {
			return Response::json(
				array
				(
					"status" => "fail", 
					"data" => "Attempting to add items a unauthorized list."
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
		$item = Item::findOrFail($id);

		if (Auth::user()->id == $item->roll_id)
		{
			$item->delete();
			return Response::json(
					array
					(
						"status" => "success", 
						"data" => "Item has been deleted."
					)
					);
		}
	}

}