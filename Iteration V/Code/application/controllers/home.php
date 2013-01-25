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

	public function more_follow_pics() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('follow');

		$offset = $this->input->post('page');
		$user_id = $this->ci->session->userdata('user_id');
		$pictures = $this->ci->follow->get_followed_pictures($user_id, $offset);

		$is_logged_in = $this->tank_auth->is_logged_in();

		$state = 'false';
		$data = '';
		if ($pictures) {
			if ($offset == 0 && count($pictures) < 20/* handy threshold! :P */) {
				$state = 'true';
			}
			foreach ($pictures as $pic_obj) {
				$name = $pic_obj['username'];
				if ($pic_obj['complete_name'] && $pic_obj['complete_name'] != '') {
					$name = $pic_obj['complete_name'];
				}
				
				$tool_box = '';
				if ($is_logged_in) {
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
				            <a href="#">
				              <img src="'.$pic_obj["path"].'" style="width: 100%;" />
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
		else {
			$state = 'true';
		}

		echo json_encode(array('html' => $data,
							   'state' => $state));
	}

	public function more_public_pics() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture');

		$is_logged_in = $this->tank_auth->is_logged_in();
		$offset = $this->input->post('page');
		$pictures = $this->ci->picture->get_public_pictures($is_logged_in, $offset);

		$data = '';
		if ($pictures) {
			foreach ($pictures as $pic_obj) {
				$name = $pic_obj['username'];
				if ($pic_obj['complete_name'] && $pic_obj['complete_name'] != '') {
					$name = $pic_obj['complete_name'];
				}
				
				$tool_box = '';
				if ($is_logged_in) {
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
					<li onMouseOver="ShowActions(this)" onMouseOut="HideActions(this)">';
						if ($is_logged_in) {
				        	$data = $data.'<figure class="cap-bot">';
			        	}
			        	$data = $data.'
				          <div class="pick-holder" id="pic_'.$pic_obj["id"].'">
				            '.$tool_box.'
				            <a href="#">
				              <img src="'.$pic_obj["path"].'" style="width: 100%;" />
				            </a>';
				            if ($is_logged_in) {
				            	$data = $data.'
					            <figcaption>
					              <span class="record pull-right">
					                <i class="icon-comment icon-white record-img"></i> <span class="record-comment">'.$pic_obj['comments'].'</span>
					                <i class="icon-heart icon-white record-img"></i> <span class="record-like">'.$pic_obj['likes'].'</span>
					              </span>
					            </figcaption>';
					        }
					        $data = $data.'
				          </div>';
				        if ($is_logged_in) {
				        	$data = $data.'</figure>';
			        	}
			        	$data = $data.'
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

	public function like_picture() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('feel');

		$user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if ($this->ci->feel->like($user_id,
								  $picture_id)) {
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
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if ($this->ci->feel->dislike($user_id,
								  	 $picture_id)) {
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
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		$comments = $this->ci->comment->load_all_comments($picture_id);
		
		$comments_block = "";
		foreach ($comments as $comment) {
			$comments_block = $comments_block.'
			  <div class="comment">
	            <div class="comment-header">
	              <div class="btn-group pull-right">
	                <a class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
	                <ul class="dropdown-menu">
	                  <li><a href="#"><i class="icon-flag"></i> Report Violation</a></li>
	                </ul>
	              </div>
	              <img src="'.$comment['pic'].'" class="img-circle pull-left commenter-pic" style="width: 50px; height: 50px;" />
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

		$this->form_validation->set_rules('comment_content', 'Comment Content', 'trim|xss_clean');

		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
			if ($this->ci->comment->add_comment_to_picture($user_id,
													   $picture_id,
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

		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run()) {
			$user_id = $this->ci->session->userdata('user_id');
			$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
			if ($this->ci->picture_album->add_picture_to_album($user_id,
													   $picture_id,
													   $this->input->post('album_name'),
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
			$albums_block.='<li style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
							<a onClick="SetCurrentAlbum(this.innerHTML)">
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
		
		$notifications_cotent = '<li><div style="padding: 5px 15px; font-weight: bold; color: #999;">Recent Events</div></li>';
		if (count($notifications) < 1) {
			$notifications_cotent = $notifications_cotent.'
									<li class="divider"></li>
			  						<li><a>
		  							<div style="font-weight: bold; padding-top: 5px; padding-bottom: 5px;">No Activity</div>
			  						</a></li>';
		}
		else {
			foreach ($notifications as $notification) {
				$notifications_cotent = $notifications_cotent.'
										<li class="divider"></li>
				  						<li><a><div style="font-weight: bold;">
			  							'.$notification['description'].'
				  						</div><div style="font-size: 11px;">
				  						'.$notification['date'].'
				  						</div></a></li>';
			}
		}
		echo json_encode($notifications_cotent);
	}

	public function add_pick_notification() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('notification');
		$subject_user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if($this->ci->notification->add_pick_notification($subject_user_id, $picture_id)) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}

	public function add_like_notification() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('notification');
		$subject_user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if($this->ci->notification->add_like_notification($subject_user_id, $picture_id)) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}

	public function add_comment_notification() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('notification');
		$subject_user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if($this->ci->notification->add_comment_notification($subject_user_id, $picture_id)) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}
}