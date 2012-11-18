<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function index() {	

		$this->title = "Pickr";

		$this->_render('pages/home');
	}

	public function setting() {

		if (!$this->tank_auth->is_logged_in()) {
			redirect('index.php/home/index');
		}
		else {
			$this->title = "Setting";

			$this->_render('pages/setting');
		}
	}

	public function changePassword()
	{
		// auth/change_password inja bayad seda shavad. ba click kardan bar ruye dokmeye "change password"
	}

	public function updateProfile() {
		
	}
}