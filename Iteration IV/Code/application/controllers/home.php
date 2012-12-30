<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index() {
		$this->title = "Pickr";
		if ($this->tank_auth->is_logged_in()) {
			$this->ci =& get_instance();
			$this->ci->load->database();
			$this->ci->load->model('album_model');
			$this->ci->load->model('follow');			
			$this->ci->load->model('picture_album');
			$this->ci->load->model('picture');				

			$user_id = $this->ci->session->userdata('user_id');
			$followed_albums = $this->ci->follow->get_followed_ids($user_id);
			$limit = array( 'start' => "0" ,
							'length' => "24");
			$followed_pictures = array();
			$followed_pictures = $this->ci->picture_album->get_followed_pictures($followed_albums,$limit);
			$public_pictures = array();
			$public_pictures = $this->ci->picture->get_public_pictures($limit);
				
			$ctr = 24-count($followed_pictures);
			if(count($followed_pictures)<24){

				foreach($public_pictures as $pic => $id){					
					$followed_pictures[$pic] = $id;
					if($ctr++ == 24) break 1 ;
				}
			}

			$this->data['public_pictures'] = $public_pictures;
			$this->data['followed_pictures'] = $followed_pictures;
			$this->data['albums'] = $this->ci->album_model->get_all_album_name($user_id); 

		}
		$this->_render('pages/home');
	}

	public function more_pics(){
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('follow');			
		$this->ci->load->model('picture_album');
		$this->ci->load->model('picture');	
					
		$requested_page = $this->input->post('page_num');
		$user_id = $this->ci->session->userdata('user_id');				
		$followed_albums = $this->ci->follow->get_followed_ids($user_id);		
		$limit = array( 'start' => (($requested_page - 1) * 24) ,
						'length' => "24");				
		$followed_pictures = $this->ci->picture_album->get_followed_pictures($followed_albums,$limit);
		$count = $this->ci->picture_album->count_followed_pictures($followed_albums);	

		if($requested_page < ((($count - ($count % 24)) / 24)+1)) {
		$pics_block ="";

        	foreach($followed_pictures as $pic => $pic_id){		
				$pics_block =$pics_block.'
        			<div class="article">
              			<div class="frame">
                			<figure class="cap-bot">
                  				<div class="inner-box" id="'.$pic_id.'">                   	
                      				<span class="tool-box">
                          				<a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i> Pick</a>
                          				<a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          				<a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                      				</span>
                      				<a class="pic-link" href="#">
                          				<img id="pic_'.$pic_id.'" class="lazy" src="'.$pic.'" data-original="'.$pic.'" alt="pic_'.$pic_id.'" />
                      				</a> 
                        			<figcaption>
                        				<span>by unknown photographer</span>
                        				<span class="record pull-right">
                            			<i class="icon-comment icon-white record-img"></i> <span class="record-comment">'.(2 * $pic_id + 3).'</span>
                            			<i class="icon-heart icon-white record-img"></i> <span class="record-like">'.(2 * $pic_id + 1).'</span>
                        				</span>
                   					</figcaption>
                  				</div>
              				</figure>
            			</div>
        			</div>';
        	}
		}
		else{
			$limit = array( 'start' => (($requested_page - ((($count - ($count % 24)) / 24)+1)) * 24) ,
							'length' => "24");
			$public_pictures = $this->ci->picture->get_public_pictures($limit);

			$ctr = 24-count($followed_pictures);
			if(count($followed_pictures)<24){
				foreach($public_pictures as $pic => $id){					
					$followed_pictures[$pic] = $id;
					if($ctr++ == 24) break 1 ;
				}
			}
			$pics_block ="";

        		foreach($followed_pictures as $pic => $pic_id){			
				$pics_block =$pics_block.'
       			 	<div class="article">
              		<div class="frame">
               		 	<figure class="cap-bot">
                  			<div class="inner-box" id="'.$pic_id.'">                   	
                      			<span class="tool-box">
                          			<a href="#pick" role="button" class="btn btn-small pick-btn" data-toggle="modal"><i class="icon-magnet"></i> Pick</a>
                          			<a href="#comment" role="button" class="btn btn-small comment-btn" data-toggle="modal"><i class="icon-comment"></i></a>
                          			<a class="btn btn-small like-btn" href="#"><i class="icon-thumbs-up"></i></a>
                      			</span>
                      			<a class="pic-link" href="#">
                        	  		<img id="pic_'.$pic_id.'" class="lazy" src="'.$pic.'" data-original="'.$pic.'" alt="pic_'.$pic_id.'" />
                      			</a> 
                        		<figcaption>
                        			<span>by unknown photographer</span>
                        			<span class="record pull-right">
                            		<i class="icon-comment icon-white record-img"></i> <span class="record-comment">'.(2 * $pic_id + 3).'</span>
                            		<i class="icon-heart icon-white record-img"></i> <span class="record-like">'.(2 * $pic_id + 1).'</span>
                        			</span>
                   				</figcaption>
                  			</div>
              			</figure>
            		</div>
        		</div>';
        	}						
		}		
		echo json_encode($pics_block);				
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
	                  <li><a><i class="icon-flag"></i> Report Violation</a></li>
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
		$user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if($this->ci->notification->add_pick_notification($user_id, $picture_id)) {
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
		$user_id = $this->ci->session->userdata('user_id');
		$picture_id = preg_replace('![^0-9]+!i', '', $this->input->post('picture_id'));
		if($this->ci->notification->add_like_notification($user_id, $picture_id)) {
			echo json_encode(TRUE);
		}
		else {
			echo json_encode(FALSE);
		}
	}
}