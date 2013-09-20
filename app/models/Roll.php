<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Roll extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rolls';

	/**
	 * A model is inheritantly error-free, we must validate.
	 *
	 * @var boolean
	 */
    protected $errors = null;

	/**
	 * The scope to access public lists.
	 *
	 * @return Roll
	 */
	public function scopeShared($query)
    {
        return $query->where('public', '=', "1");
    }

    /**
	 * Retrieives any validation errors if any.
	 *
	 * @return mixed
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Gets the highest order number, so we know what to assign 
	 * new list items
	 *
	 * @return int
	 */
	public function topOrder()
	{
		return DB::table('items')
			->where('roll_id', '=', $this->id)
			->orderBy('order', 'desc')
			->first()->order;
	}

	/**
	 * Gets the count of how many items the list has.
	 *
	 * @return int
	 */
	public function itemCount()
	{
		return count($this->items);
	}

	/**
	 * Validates the list and sets the error variable to true or false.
	 *
	 */
    public function validate()
	{
		$checka = Validator::make($this->attributes,
			array(
				'name' => 'required|min:2|max:255|unique:rolls,name,' . $this->id . ',id,user_id,' . $this->user->id,
				'public' => 'required|between:0,1'
			)
		);

		if ($checka->passes())
		{
			return true;
		}
		else 
		{
			$this->errors = $checka->messages()->all();

			return false;
		}


	}

	/**
	 * Inverse relationship so we can find what user the list belongs to.
	 *
	 * @return User
	 */
    public function user()
    {
    	return $this->belongsTo('User');
    }

    /**
	 * One to many relationship so we can find the items in a list.
	 * Ordered  by "order"
	 * 
	 * @return Item
	 */
    public function items()
    {
    	return $this->hasMany('Item')->orderBy('order');
    }

    /**
	 * Gets the most recent lists from a user
	 *
	 * @param $user
	 * @param $page
	 *
	 * @return Roll
	 */
    public static function mostRecent($user, $page = 1)
    {
    	$page = $page - 1;

    	return Roll::where('user_id', '=', $user->id)->skip($page * 10)->take(10)->get();
    }

    /**
	 * Changes the order of all the items in the list.
	 *
	 * @param array $order
	 *
	 */
    public function changeItemOrder($order)
    {

		$temp_items = array();

		$x = 0;

		foreach ($order as $order_part)
		{

			$temp_item = $this->items()->where('order', '=', $order_part)->first();

			$temp_item->order = $x;

			array_push($temp_items, $temp_item);
			$x++;
		}
		foreach ($temp_items as $item)
		{
			$item->save();
		}
	}
}