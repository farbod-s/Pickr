<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function user($user_id){
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->data['profile_info'] = $this->ci->users->pickr_get_profile($user_id);		
		$username = $this->ci->users->get_username($user_id);		
		$this->title = $username;
		$this->ci->load->model('album');
		$this->data['albums'] = $this->ci->album->get_all_album_name($user_id);
		$this->_render('pages/profile');		
	}

	public function index() {

	}
}