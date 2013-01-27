<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

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

	public function user($username) {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('album_model');
		$this->ci->load->model('follow');
		$this->ci->load->model('picture_album');
		$this->ci->load->model('feel');	

		if(!$this->ci->users->is_username_available($username)) { // user exist
			$ME = FALSE;
			$user_id = $this->ci->users->get_user_by_username($username)->id;
			if($user_id == $this->ci->session->userdata('user_id')) {
				$ME = TRUE;
				if (!$this->tank_auth->is_logged_in()) {
					redirect(base_url());
				}
			}
			$self_user_id = $this->ci->session->userdata('user_id');
			$album_ids = $this->ci->album_model->get_all_album_ids($user_id);
			if (!$ME) {
				$this->data['person_followed'] = $this->ci->follow->is_person_followed($self_user_id,$album_ids);
				$this->data['followed_albums'] = $this->ci->follow->get_followed_ids($self_user_id);
			}
			$this->data['profile_info'] = $this->ci->users->pickr_get_profile($user_id);
			$this->data['following_count'] = $this->ci->follow->get_following_count($user_id);
			$this->data['follower_count'] = $this->ci->follow->get_follower_count($user_id);
			$this->data['like_count'] = $this->ci->feel->get_user_like_count($user_id);
			$this->data['pick_count'] = $this->ci->picture_album->get_user_pick_count($user_id);
			$this->data['albums_detail'] = $this->ci->album_model->get_albums_detail($user_id);
			$this->data['ME'] = $ME;
			$this->data['username'] = $username;
			$this->data['user_id'] = $user_id;			

			$this->title = strtolower($username);

			$this->_render('pages/profile');
		}
		else {
			redirect(base_url());
		}
	}

	public function new_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album_model');

		$this->form_validation->set_rules('album_name', 'Album Name', 'trim|required|xss_clean|min_length[1]|max_length[50]');
		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			if ($this->ci->album_model->create_album($this->form_validation->set_value('album_name'), $user_id)) {
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
	
	public function follow_person() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('follow');
		$this->ci->load->model('album_model');	

		$user_id = $this->ci->users->get_user_by_username($this->input->post('username'))->id;
		$album_ids = $this->ci->album_model->get_all_album_ids($user_id);
		$user_id = $this->ci->session->userdata('user_id');
		$this->ci->follow->insert_follow_all($user_id, $album_ids);

		echo json_encode(TRUE);
	}

	public function unfollow_person() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');
		$this->ci->load->model('follow');
		$this->ci->load->model('album_model');	

		$user_id = $this->ci->users->get_user_by_username($this->input->post('username'))->id;
		$album_ids = $this->ci->album_model->get_all_album_ids($user_id);
		$user_id = $this->ci->session->userdata('user_id');	
		$this->ci->follow->delete_follow_all($user_id, $album_ids);

		echo json_encode(TRUE);	
	}	

	public function follow_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('follow');

		$album_id = preg_replace('![^0-9]+!i', '', $this->input->post('album_id'));
		$user_id = $this->ci->session->userdata('user_id');

		$this->ci->follow->insert_follow($user_id, $album_id);
		
		echo json_encode(TRUE);
	}
	public function unfollow_album() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('follow');

		$album_id = preg_replace('![^0-9]+!i', '', $this->input->post('album_id'));
		$user_id = $this->ci->session->userdata('user_id');

		$this->ci->follow->delete_follow($user_id, $album_id);
		
		echo json_encode(TRUE);
	}

	public function add_follow_notification() {
		/* $this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('notification');
		$subject_user_id = $this->ci->session->userdata('user_id');
		$album_id = preg_replace('![^0-9]+!i', '', $this->input->post('album_id'));
		if($this->ci->notification->add_follow_notification($subject_user_id, $album_id)) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		} */
	}

	public function add_follow_all_notification() {

	}
}