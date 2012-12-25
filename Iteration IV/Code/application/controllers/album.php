<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends MY_Controller {

	function __construct() {
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) {
			redirect(base_url());
		}
	}

	public function index() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		
		$username = $this->ci->users->get_username($this->ci->session->userdata('user_id'));
		redirect(base_url('user/'.strtolower($username)));
	}

	public function edit($username, $album_name) {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('album_model');
		$this->ci->load->model('picture_album');

		if(!$this->ci->users->is_username_available($username)) { // user exist
			$ME = FALSE;
			$user_id = $this->ci->users->get_user_by_username($username)->id;
			if($this->ci->album_model->is_album_exist($user_id, $album_name)) {
				// album exist for this user
				if($user_id == $this->ci->session->userdata('user_id')) {
					$ME = TRUE;
					if (!$this->tank_auth->is_logged_in()) {
						redirect(base_url());
					}
				}
			}
			else {
				redirect(base_url('user/'.strtolower($username)));
			}
			$this->data['profile_info'] = $this->ci->users->pickr_get_profile($user_id);
			$this->data['album_info'] = $this->ci->album_model->get_album_information($user_id, $album_name);
			$this->data['pictures'] = $this->ci->picture_album->get_album_pictures($user_id, $album_name);
			$this->data['ME'] = $ME;
			$this->data['username'] = $username;

			$this->title = strtolower($username).'/'.strtolower($album_name);

			$this->_render('pages/album');
		}
		else {
			redirect(base_url());
		}
	}

	

	public function delete($albumId = -1) {
		$this->ci = &get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture_album');
		$this->picture_album->delete_album($albumId);
        redirect(base_url().'index.php/');
	}

	public function rename($albumId = -1) {
		$newname = $this->input->get('newname', TRUE);
		$this->load->database();
		mysql_query("UPDATE album SET name= '$newname' where id=$albumId");
		redirect(base_url().'index.php/'.'album/view/'.$albumId);
	}
	
	public function deletepic($picId = -1, $albumId= -1) {
		$this->ci = &get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture_album');
		$this->picture_album->delete_pic($picId,$albumId);
        redirect(base_url().'index.php/'.'album/view/'.$albumId);
	}
}
