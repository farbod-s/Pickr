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

			$this->data['profile_info'] = $this->tank_auth->get_profile();

			$this->_render('pages/setting');
		}
	}

	public function update_setting() {
		$this->form_validation->set_rules('firstName', 'First Name', 'trim|xss_clean');
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean');
		$this->form_validation->set_rules('country', 'Location', 'trim|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('pic_address', 'Pic Address', 'trim|xss_clean');

		echo 'hello';

		echo $this->form_validation->set_value('country');

		if($this->form_validation->run()) {
			$this->tank_auth->update_profile($this->form_validation->set_value('country'),
											 $this->form_validation->set_value('website'),
											 $this->form_validation->set_value('firstName'),
											 $this->form_validation->set_value('lastName'),
											 $this->form_validation->set_value('gender'),
											 $this->form_validation->set_value('description'),
											 $this->form_validation->set_value('pic_address'));


			echo json_encode(true);
		}
		else {
			echo json_encode(false);
		}

	}

	public function changePassword()
	{
		// auth/change_password inja bayad seda shavad. ba click kardan bar ruye dokmeye "change password"
	}

	public function updateProfile() {
		
	}
}