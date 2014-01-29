<?php

class BaseController extends Controller {
	
	/**
	 * Save URL Referer to Session.
	 * 
	 */
	public function saveReferer()
	{
		if(Session::has('errors')) return;
		Session::put('url.referer', Request::header('referer'));
	}
	
	/**
	 * Get URL Referer Redirect if exists.
	 * 
	 * @param \Illuminate\Http\RedirectResponse $redirect
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function redirectReferer($redirect)
	{
		if (Session::has('url.referer')) 
		{
			$redirect = Redirect::to(Session::get('url.referer'));
			Session::forget('url.referer');
		}
		return $redirect;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}