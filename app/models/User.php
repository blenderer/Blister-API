<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'deleted_at', 'rolls');

	/**
	 * Stores an array of errors if there is a validation error.
	 *
	 * @var array
	 */
	protected $errors = null;

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
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
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Validates the user registration and sets the error variable 
	 * to true or false.
	 *
	 */
	public function validate()
	{
		$checka = Validator::make($this->attributes,
			array(
				'username' => 'required|min:2|unique:users',
				'password' => 'required|min:6'
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
	 * One to many relationship so we can see what rolls belong to the user
	 *
	 * @return Roll
	 */
	public function rolls()
	{
		return $this->hasMany('Roll');
	}
}