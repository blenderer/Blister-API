<?php

class ItemController extends \BaseController {

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
		//Need- roll_id, item_text, 

		$item = new Item();

		$item->roll_id = Input::get("roll_id");
		$item->item_text = Input::get("item_text");

		if (Auth::user()->id == $item->roll_id)
		{
			
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

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

}