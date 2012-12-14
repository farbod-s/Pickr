<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function user($user_id){
		$this->ci =& get_instance();
		$this->load->helper('url');
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('album');
		
		$this->data['profile_info'] = $this->ci->users->pickr_get_profile($user_id);	
		$this->data['first_pics'] = $this->ci->album->get_pic_of_album($user_id);		
		
		$username = $this->ci->users->get_username($user_id);		
		$this->title = $username;
		
		$this->data['albums'] = $this->ci->album->get_all_album_name($user_id);
		
		$this->_render('pages/profile');		
	}

	public function index() {

	}
}