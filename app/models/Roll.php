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
	 * The scope to access public lists.
	 *
	 * @return Lizt
	 */
	public function scopeShared($query)
    {
        return $query->where('public', '=', "1");
    }

    protected $errors = null;

    /**
	 * Retrieives any validation errors if any.
	 *
	 * @return mixed
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	public function topOrder()
	{
		return DB::table('items')
			->where('roll_id', '=', $this->id)
			->orderBy('order', 'desc')
			->first()->order;
	}

	public function itemCount()
	{
		return count($this->items);
	}

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

    public function user()
    {
    	return $this->belongsTo('User');
    }

    public function items()
    {
    	return $this->hasMany('Item')->orderBy('order');
    }

    public static function mostRecent($user, $page = 1)
    {
    	$page = $page - 1;

    	return Roll::where('user_id', '=', $user->id)->skip($page * 10)->take(10)->get();
    }

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