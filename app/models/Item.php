<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Item extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';

	/**
	 * These fields are hidden when toArray or json_encode is done.
	 *
	 * @var array
	 */
	protected $hidden = array('roll');

	/**
	 * Inverse relation so we can see what list this item belongs to
	 *
	 * @return Roll
	 */
	public function roll()
    {
    	return $this->belongsTo('Roll');
    }

    /**
	 * One to many relation so we can view the items that make up the list.
	 *
	 * @return Roll
	 */
    public function items()
    {
    	return $this->hasMany('Item');
    }
}