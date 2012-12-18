<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index() {
		$this->title = "Pickr";
		if ($this->tank_auth->is_logged_in()) {
			$this->ci =& get_instance();
			$this->ci->load->database();
			$this->ci->load->model('album');

			$user_id = $this->ci->session->userdata('user_id');
			$this->data['albums'] = $this->ci->album->get_all_album_name($user_id);
		}
		$this->_render('pages/home');
	}

	public function like_picture() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('feel');

		$user_id = $this->ci->session->userdata('user_id');
		if ($this->ci->feel->like($user_id,
								  $this->input->post('picture_path'))) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}

	public function dislike_picture() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('feel');

		$user_id = $this->ci->session->userdata('user_id');
		if ($this->ci->feel->dislike($user_id,
								  	 $this->input->post('picture_path'))) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}

	public function comment_on_picture() {
		// TODO
	}

	public function add_pic_to_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture_album');

		$this->form_validation->set_rules('picture_path', 'Picture Path', 'trim|xss_clean');
		//$this->form_validation->set_rules('album_name', 'Album Name', 'trim|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			if ($this->ci->picture_album->add_picture_to_album($user_id,
													   $this->form_validation->set_value('picture_path'),
													   trim($this->input->post('album_name')),
													   $this->form_validation->set_value('description'))) {
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

	public function create_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album');

		$this->form_validation->set_rules('album_name', 'Album Name', 'trim|xss_clean');
		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			if ($this->ci->album->create_album($this->form_validation->set_value('album_name'), $user_id)) {
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