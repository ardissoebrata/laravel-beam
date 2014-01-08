<?php

/*
  |--------------------------------------------------------------------------
  | Confide Controller Template
  |--------------------------------------------------------------------------
  |
  | This is the default Confide controller template for controlling user
  | authentication. Feel free to change to your needs.
  |
 */

class UserController extends BaseController
{

	/**
	 * Displays the form for account creation
	 *
	 */
	public function getCreate()
	{
		return View::make(Config::get('confide::signup_form'));
	}

	/**
	 * Stores new account
	 *
	 */
	public function postCreate()
	{
		$user = new User;

		$user->name = Input::get('name');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->password = Input::get('password');

		// The password confirmation will be removed from model
		// before saving. This field will be used in Ardent's
		// auto validation.
		$user->password_confirmation = Input::get('password_confirmation');

		// Save if valid. Password field will be hashed before save
		$user->save();

		if ($user->id)
		{
			// Redirect with success message, You may replace "Lang::get(..." for your custom message.
			return Redirect::to('user/login')
							->with('notice', Lang::get('confide.alerts.account_created'));
		}
		else
		{
			// Get validation errors (see Ardent package)
			$error = $user->errors()->all(':message');

			return Redirect::to('user/create')
							->withInput(Input::except('password'))
							->with('error', $error);
		}
	}

	/**
	 * Displays the login form
	 *
	 */
	public function getLogin()
	{
		if (Confide::user())
		{
			// If user is logged, redirect to internal 
			// page, change it to '/admin', '/dashboard' or something
			return Redirect::to('/');
		}
		else
		{
			return View::make(Config::get('confide::login_form'));
		}
	}

	/**
	 * Attempt to do login
	 *
	 */
	public function postLogin()
	{
		$input = array(
			'email' => Input::get('email'), // May be the username too
			'username' => Input::get('email'), // so we have to pass both
			'password' => Input::get('password'),
			'remember' => Input::get('remember'),
		);

		// If you wish to only allow login from confirmed users, call logAttempt
		// with the second parameter as true.
		// logAttempt will check if the 'email' perhaps is the username.
		// Get the value from the config file instead of changing the controller
		if (Confide::logAttempt($input, Config::get('confide::signup_confirm')))
		{
			// Redirect the user to the URL they were trying to access before
			// caught by the authentication filter IE Redirect::guest('user/login').
			// Otherwise fallback to '/'
			// Fix pull #145
			return Redirect::intended('/'); // change it to '/admin', '/dashboard' or something
		}
		else
		{
			$user = new User;

			// Check if there was too many login attempts
			if (Confide::isThrottled($input))
			{
				$err_msg = Lang::get('confide.alerts.too_many_attempts');
			}
			elseif ($user->checkUserExists($input) and !$user->isConfirmed($input))
			{
				$err_msg = Lang::get('confide.alerts.not_confirmed');
			}
			else
			{
				$err_msg = Lang::get('confide.alerts.wrong_credentials');
			}

			return Redirect::to('user/login')
							->withInput(Input::except('password'))
							->with('error', $err_msg);
		}
	}

	/**
	 * Attempt to confirm account with code
	 *
	 * @param  string  $code
	 */
	public function getConfirm($code)
	{
		if (Confide::confirm($code))
		{
			$notice_msg = Lang::get('confide.alerts.confirmation');
			return Redirect::to('user/login')
							->with('notice', $notice_msg);
		}
		else
		{
			$error_msg = Lang::get('confide.alerts.wrong_confirmation');
			return Redirect::to('user/login')
							->with('error', $error_msg);
		}
	}

	/**
	 * Displays the forgot password form
	 *
	 */
	public function getForgot()
	{
		return View::make(Config::get('confide::forgot_password_form'));
	}

	/**
	 * Attempt to send change password link to the given email
	 *
	 */
	public function postForgot()
	{
		if (Confide::forgotPassword(Input::get('email')))
		{
			$notice_msg = Lang::get('confide.alerts.password_forgot');
			return Redirect::to('user/login')
							->with('notice', $notice_msg);
		}
		else
		{
			$error_msg = Lang::get('confide.alerts.wrong_password_forgot');
			return Redirect::to('user/forgot')
							->withInput()
							->with('error', $error_msg);
		}
	}

	/**
	 * Shows the change password form with the given token
	 *
	 */
	public function getReset($token)
	{
		return View::make(Config::get('confide::reset_password_form'))
						->with('token', $token);
	}

	/**
	 * Attempt change password of the user
	 *
	 */
	public function postReset()
	{
		$input = array(
			'token' => Input::get('token'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
		);

		// By passing an array with the token, password and confirmation
		if (Confide::resetPassword($input))
		{
			$notice_msg = Lang::get('confide.alerts.password_reset');
			return Redirect::to('user/login')
							->with('notice', $notice_msg);
		}
		else
		{
			$error_msg = Lang::get('confide.alerts.wrong_password_reset');
			return Redirect::to('user/reset/' . $input['token'])
							->withInput()
							->with('error', $error_msg);
		}
	}

	/**
	 * Log the user out of the application.
	 *
	 */
	public function getLogout()
	{
		Confide::logout();

		return Redirect::to('/');
	}

	public function getIndex()
	{
		$users = User::all();
		return View::make('user/index', compact('users'));
	}
	
	public function getEdit($id)
	{
		$user = User::findOrFail($id);
		return View::make('user/edit', compact('user'));
	}
	
	public function postEdit($id)
	{
		$user = User::findOrFail($id);
		$user->name = Input::get('name');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		
		$password = Input::get('password');
		if (!empty($password)) {
			$user->password = $password;
			$user->password_confirmation = Input::get('password_confirmation');
		}
		
		if ($user->updateUniques($user->getUpdateRules()))
		{
			// Redirect with success message, You may replace "Lang::get(..." for your custom message.
			return Redirect::to('user/index')
							->with('notice', Lang::get('confide.alerts.account_updated'));
		}
		else
		{
			return Redirect::action('UserController@getEdit', $id)
							->withInput(Input::except('password'))
							->withErrors($user->errors());
		}
	}
}
