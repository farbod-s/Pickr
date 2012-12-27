<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index() {
		$this->title = "Pickr";
		if ($this->tank_auth->is_logged_in()) {
			$this->ci =& get_instance();
			$this->ci->load->database();
			$this->ci->load->model('album_model');

			$user_id = $this->ci->session->userdata('user_id');
			$this->data['albums'] = $this->ci->album_model->get_all_album_name($user_id);
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

	public function load_comments() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('comment');

		$comments = array();
		$comments = $this->ci->comment->load_all_comments($this->input->post('picture_path'));
		
		$comments_block = "";
		foreach ($comments as $comment) {
			$comments_block = $comments_block.'
			  <div class="comment">
	            <div class="comment-header">
	              <div class="btn-group pull-right">
	                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
	                <ul class="dropdown-menu">
	                  <li><a href="#"><i class="icon-flag"></i> Report Violation</a></li>
	                </ul>
	              </div>
	              <img src="'.base_url(IMAGES.'in.jpg').'" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
	              <h4 class="commenter-name">'.$comment['username'].'</h4>
	              <div class="commenter-date">'.$comment['date'].'</div>
	            </div>
	            <hr class="soft">
	            <div class="comment-body">
	              '.$comment['comment'].'
	            </div>
	          </div>';
		}

		echo json_encode($comments_block);
	}

	public function comment_on_picture() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('comment');

		$this->form_validation->set_rules('picture_path', 'Picture Path', 'trim|xss_clean');
		$this->form_validation->set_rules('comment_content', 'Comment Content', 'trim|xss_clean');

		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			if ($this->ci->comment->add_comment_to_picture($user_id,
													   $this->form_validation->set_value('picture_path'),
													   $this->form_validation->set_value('comment_content'))) {
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
		$this->ci->load->model('album_model');

		$this->form_validation->set_rules('album_name', 'Album Name', 'trim|xss_clean');
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

	public function load_albums() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('album_model');

		$user_id = $this->ci->session->userdata('user_id');
		$albums = $this->ci->album_model->get_all_album_name($user_id);

		$albums_block = "";
		foreach ($albums as $album) {
			$albums_block.='<li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a href="#" onClick="SetCurrentAlbum(this.innerHTML)">
							'.htmlspecialchars($album).'
							</a></li>';
		}
		echo json_encode($albums_block);
	}

	public function load_notifications() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('notification');
		$user_id = $this->ci->session->userdata('user_id');

		$notifications = array();
		$notifications = $this->ci->notification->load_notifications($user_id);
		
		$notifications_cotent = '<li><strong style="margin-left: 35px;"> Recent Events </strong></li>';
		foreach ($notifications as $notification) {
			$notifications_cotent = $notifications_cotent.'<li class="divider"></li>
			  <li style="margin-left: 5px;">'.$notification['date'].': <strong>'.$notification['description'].'</strong></li>';
		}

		echo json_encode($notifications_cotent);
	}
}