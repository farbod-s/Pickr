<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends MY_Controller {

	function __construct() {
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) {
			redirect(base_url());
		}
	}

	public function index() {

		$this->title = "Setting";

		// load user setting
		$this->data['profile_info'] = $this->tank_auth->get_profile();

		$this->_render('pages/setting');
	}

	public function update_setting() {
		$this->form_validation->set_rules('country', 'Location', 'trim|xss_clean');
		$this->form_validation->set_rules('website', 'Website', 'trim|xss_clean');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|xss_clean');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'integer');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('pic_address', 'Pic Address', 'trim|xss_clean');

		if($this->form_validation->run()) {
			if($this->tank_auth->update_profile($this->form_validation->set_value('country'),
											 	$this->form_validation->set_value('website'),
											 	$this->form_validation->set_value('firstname'),
											 	$this->form_validation->set_value('lastname'),
											 	$this->form_validation->set_value('gender'),
											 	$this->form_validation->set_value('description'),
											 	$this->form_validation->set_value('pic_address'))) {
				echo json_encode(TRUE);
			}
			else {
				echo json_encode(FALSE);
			}		
		}
		else {
			echo json_encode(FALSE);
		}
	}
}