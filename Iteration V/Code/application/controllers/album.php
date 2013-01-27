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

	public function more_pics() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture_album');
		$this->ci->load->model('tank_auth/users');

		$album_name = $this->input->post('album_name');
		$user_id = $this->ci->users->get_user_by_username($this->input->post('username'))->id;
		$ME = FALSE;
		if($user_id == $this->ci->session->userdata('user_id')) {
			$ME = TRUE;
		}

		$offset = $this->input->post('page');
		$pictures = $this->ci->picture_album->get_album_pictures($user_id, $album_name, $ME, $offset);

		$data = '';
		if ($pictures) {
			foreach ($pictures as $pic_obj) {
				$name = $pic_obj['username'];
				if ($pic_obj['complete_name'] && $pic_obj['complete_name'] != '') {
					$name = $pic_obj['complete_name'];
				}

				if ($ME) {
					$tool_box = '';
							$tool_box = $tool_box.'
										<span class="tool-box">
								            <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-share"></i> Repick</a>
								            <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
								            <a class="btn btn-small delete-picture-btn"><i class="icon-trash"></i></a>
								        </span>';
				}
				else {
					$tool_box = '';
							$tool_box = $tool_box.'
										<span class="tool-box">
								            <a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-share"></i> Pick</a>
								            <a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
								            <a class="btn btn-small like-btn"><i class="icon-thumbs-up"></i></a>
								        </span>';

					if($pic_obj['is_liked'] == true) {
						$tool_box = str_replace("icon-thumbs-up", "icon-thumbs-down", $tool_box);
						$tool_box = str_replace("like-btn", "dislike-btn", $tool_box);
					}
				}

				$data = $data.'
					<li onMouseOver="ShowActions(this)" onMouseOut="HideActions(this)">
				        <figure class="cap-bot">
				          <div class="pick-holder" id="pic_'.$pic_obj["id"].'">
				            '.$tool_box.'
				            <a href="'.$pic_obj["path"].'" target="_blank">
				              <img src="'.$pic_obj["path"].'" style="width: 100%; cursor: -webkit-zoom-in;" />
				            </a>
				            <figcaption>
				              <span class="record pull-right">
				                <i class="icon-comment icon-white record-img"></i> <span class="record-comment">'.$pic_obj['comments'].'</span>
				                <i class="icon-heart icon-white record-img"></i> <span class="record-like">'.$pic_obj['likes'].'</span>
				              </span>
				            </figcaption>
				          </div>
				        </figure>
				        <div class="description">'.$pic_obj["description"].'</div>
				        <div class="photographer">
				        <a href="'.base_url('user/'.$pic_obj['username']).'">
				        '.$name.'
				        </a> - <a href="'.base_url('user/'.$pic_obj['username'].'/'.preg_replace('![^a-z0-9_]+!i', '-', strtolower($pic_obj['album_name']))).'">
				        '.$pic_obj['album_name'].'
				        </a></div>
				    </li>
				'; 
			}
		}

		echo json_encode($data);
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
			$this->data['album_info'] = $this->ci->album_model->get_album_information($user_id, $album_name);	
			$this->data['picks'] = $this->ci->picture_album->get_picture_count($user_id, $album_name);
			$this->data['follows'] = $this->ci->picture_album->get_follow_count($user_id, $album_name);
			$complete_name = '';
			if (!is_null($user = $this->ci->users->pickr_get_profile($this->ci->users->get_user_by_username($username)->id))) {
				$firstname = $user->firstname;
				$lastname = $user->lastname;
				if(isset($firstname) && !is_null($firstname) && strlen($firstname) > 0)
	 				$complete_name = $complete_name.$firstname;
	 			if(isset($lastname) && !is_null($lastname) && strlen($lastname) > 0)
	 				$complete_name = $complete_name.' '.$lastname;
			}
			$this->data['complete_name'] = (isset($complete_name) && !is_null($complete_name) && strlen($complete_name) > 0) ? $complete_name : $username;
			$this->data['username'] = $username;
			$this->data['ME'] = $ME;
			$this->data['albums'] = $this->ci->album_model->get_all_album_name($this->ci->session->userdata('user_id'));

			$this->title = strtolower($username).' / '.strtolower($album_name);

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
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if ($this->ci->picture_album->delete_pic($user_id,
								  				 $picture_id,
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

		$this->form_validation->set_rules('old_album_name', 'Old Album Name', 'trim|required|xss_clean|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('new_album_name', 'New Album Name', 'trim|required|xss_clean|min_length[1]|max_length[50]');

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

	public function set_album_cover() {
		$this->ci = &get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album_model');

		$user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if ($this->ci->album_model->set_cover($user_id,
								  			  $picture_id,
								  			  $this->input->post('album_name'))) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}
}