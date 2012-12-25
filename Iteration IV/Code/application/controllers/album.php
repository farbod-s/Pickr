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
			$this->data['albums'] = $this->ci->album_model->get_all_album_name($this->ci->session->userdata('user_id'));

			$this->title = strtolower($username).'/'.strtolower($album_name);

			$this->_render('pages/album');
		}
		else {
			redirect(base_url());
		}
	}

	public function delete_picture() {
		$this->ci = &get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture_album');

		$user_id = $this->ci->session->userdata('user_id');
		if ($this->ci->picture_album->delete_pic($user_id,
								  				 $this->input->post('picture_path'),
								  				 $this->input->post('album_name'))) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}

	public function rename_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album_model');

		$this->form_validation->set_rules('old_album_name', 'Old Album Name', 'trim|xss_clean');
		$this->form_validation->set_rules('new_album_name', 'New Album Name', 'trim|xss_clean');

		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			if ($this->ci->album_model->rename_user_album($user_id,
													   $this->form_validation->set_value('old_album_name'),
													   $this->form_validation->set_value('new_album_name'))) {
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

	public function delete_album() {
		$this->ci = &get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album_model');

		$user_id = $this->ci->session->userdata('user_id');
		if ($this->ci->album_model->delete_user_album($user_id,
								  					  $this->input->post('album_name'))) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}
}
