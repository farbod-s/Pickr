<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('index.php/home/index');
		}
		else {
			$this->title = "Dashboard";
			
			$this->data['profile_info'] = $this->tank_auth->get_profile();
			
			$this->ci =& get_instance();
			$this->ci->load->database();
			$this->ci->load->model('album');
			
			$user_id = $this->ci->session->userdata('user_id');

			$this->data['albums_detail'] = $this->ci->album->get_albums_detail($user_id);
			
			$this->_render('pages/dashboard');
		}
	}
}
