<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function user($username) {
		$this->ci =& get_instance();
		$this->load->helper('url');
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('album');

		if(!$this->ci->users->is_username_available($username)) { // user already exist
			$ME = FALSE;
			$user_id = $this->ci->users->get_user_by_username($username)->id;
			if($user_id == $this->ci->session->userdata('user_id')) {
				$ME = TRUE;
				if (!$this->tank_auth->is_logged_in()) {
					redirect(base_url());
				}
			}
			$this->data['profile_info'] = $this->ci->users->pickr_get_profile($user_id);
			$this->data['albums_detail'] = $this->ci->album->get_albums_detail($user_id);
			$this->data['ME'] = $ME;

			$this->title = $username;

			$this->_render('pages/profile');
		}
		else {
			redirect(base_url());
		}
	}
}