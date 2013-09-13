<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Lizt extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'lists';

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

    public function validate()
	{
		$checka = Validator::make($this->attributes,
			array(
				'name' => 'required|min:2|max:255|unique:lists,name,NULL,id,user_id,' . $this->user->id,
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

	public function getListData($key_array)
	{
		$return_array = array();

		if ($key_array["name"])
		{
			$return_array["name"] = $this->name;
		}

		if ($key_array["id"])
		{
			$return_array["id"] = $this->id;
		}

		if ($key_array["username"])
		{
			$return_array["username"] = $this->user->username;
		}

		if ($key_array["item_count"])
		{
			$return_array["item_count"] = 999;
		}

		if ($key_array["public"])
		{
			$return_array["public"] = $this->public;
		}

		return (object)$return_array;
	}

    public function getListInfo()
	{
		return (object)array(
				"name" => $this->name,
				"id" => $this->id,
				"user" => $this->user->username,
				"item_count" => 999
				);
	}

	/*public function getListData()
	{
		return (object)array(
				"name" => $this->name,
				"id" => $this->id,
				"user" => $this->user->username,
				"public" => $this->public,
				"items" => 999
				);
	}*/

    public function user()
    {
    	return $this->belongsTo('User');
    }

    public static function mostRecent($user, $page = 1)
    {
    	$page = $page - 1;

    	return Lizt::where('user_id', '=', $user->id)->skip($page * 10)->take(10)->get();
    }
}