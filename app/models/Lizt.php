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

    public function getListInfo()
	{
		return (object)array(
				"name" => $this->name,
				"id" => $this->id,
				"user" => $this->user->username,
				"item_count" => 999
				);
	}

	public function getListData()
	{
		return (object)array(
				"name" => $this->name,
				"id" => $this->id,
				"user" => $this->user->username,
				"public" => $this->public,
				"items" => 999
				);
	}

    public function user()
    {
    	return $this->belongsTo('User');
    }
}