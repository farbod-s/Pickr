<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {

	public function index($q) {
		$this->_render('pages/search');
	}

	public function more_search_results() {
		$this->ci =& get_instance();
		$this->ci->load->database();
		$this->ci->load->model('picture');

		$is_logged_in = $this->tank_auth->is_logged_in();
		$offset = $this->input->post('page');
		$search_str = $this->input->post('searchStr');
		$pictures = $this->ci->picture->get_search_results($search_str, $is_logged_in, $offset);

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
}