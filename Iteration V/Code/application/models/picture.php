<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Picture extends CI_Model
{
	private $table_name = 'picture';
	private $album_table_name = 'album';
	private $users_table_name = 'users';
	private $user_album_table_name = 'user_album';
	private $picture_album_table_name = 'picture_album';
	private $comment_table_name = 'comment';
	private $feel_table_name = 'feel';

	function __construct() {
		parent::__construct();
	}
	
	// find picture_id
	public function get_picture_id($picture_path) {
		$pic_id = 0;
		$this->db->where('picture', $picture_path);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) {
			$pic_id = $query->row()->id;
		}
		return $pic_id;
	}

	public function get_public_pictures($is_logged_in, $offset, $limit = 24) {
		$data = array();
		$this->db->select('*')
				 ->order_by('id', 'DESC');
		$query = $this->db->get($this->table_name, $limit, $limit * $offset);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $picture) {
				$pictures = array();

				$pictures['id'] = $picture->id;
				$pictures['path'] = $picture->picture;
				$pictures['description'] = $picture->description;
				
				$details = $this->get_picture_details($picture->id);
				$pictures['album_name'] = $details['album_name'];
				$pictures['username'] = $details['username'];
				$pictures['complete_name'] = $details['complete_name'];
				
				if ($is_logged_in) {
					$records = $this->get_picture_records($picture->id);
					$pictures['comments'] = $records['comments'];
					$pictures['likes'] = $records['likes'];

					$pictures['is_liked'] = $this->is_liked_by_user($picture->id);
				}
				array_push($data, $pictures);
			}
		}
		return $data;
	}

	private function is_liked_by_user($picture_id) {
		$user_id = $this->ci->session->userdata('user_id');
		$this->db->where('user_id', $user_id);
		$this->db->where('picture_id', $picture_id);
		$query = $this->db->get($this->feel_table_name);
		return $query->num_rows() == 1 ? TRUE : FALSE;
	}

	private function get_picture_records($picture_id) {
		$records = array();
		$records['comments'] = $this->get_count_comment($picture_id);
		$records['likes'] = $this->get_count_like($picture_id);
		return $records;
	}

	private function get_count_comment($picture_id) {
		$counts = 0;
		$this->db->where('picture_id', $picture_id);
		$counts = $this->db->count_all_results($this->comment_table_name);
        return $counts;
	}

	private function get_count_like($picture_id) {
		$counts = 0;
		$this->db->where('picture_id', $picture_id);
		$counts = $this->db->count_all_results($this->feel_table_name);
        return $counts;
	}

	private function get_picture_details($picture_id) {
		$details = array();
		$details['album_name'] = '';
		$details['username'] = '';
		$details['complete_name'] = '';
		$this->db->where('picture_id', $picture_id);
		$query = $this->db->get($this->picture_album_table_name);
		if ($query->num_rows() == 1) {
			$album_id = $query->row()->album_id;
			$details['album_name'] = $this->get_album_name($album_id);
			$user_name = $this->get_username($album_id);
			$details['username'] = $user_name['username'];
			$details['complete_name'] = $user_name['complete_name'];
		}
		return $details;
	}

	private function get_album_name($album_id) {
		$this->db->where('id', $album_id);
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() == 1) {
			return $query->row()->name;
		}
		return NULL;
	}

	private function get_username($album_id) {
		$user_id = 0;
		$this->db->where('album_id', $album_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() == 1) {
			$user_id = $query->row()->user_id;
		}
		$user_name = array();
		$user_name['username'] = '';
		$user_name['complete_name'] = '';
		$complete_name = $this->get_name($user_id);
		if($complete_name && $complete_name != '' && $complete_name != ' ') {
			$user_name['complete_name'] = $complete_name;
		}
		$this->db->where('id', $user_id);
		$query = $this->db->get($this->users_table_name);
		if ($query->num_rows() == 1) {
			$user_name['username'] = $query->row()->username;
		}
		return $user_name;
	}

	private function get_name($user_id) {
		$complete_name = "";
		$this->ci->load->model('tank_auth/users');

 		if (!is_null($user = $this->ci->users->pickr_get_profile($user_id))) {
			$firstname = $user->firstname;
			$lastname = $user->lastname;
			if(isset($firstname) && !is_null($firstname) && strlen($firstname) > 0)
 				$complete_name = $complete_name.$firstname;
 			if(isset($lastname) && !is_null($lastname) && strlen($lastname) > 0)
 				$complete_name = $complete_name.' '.$lastname;
			return $complete_name;
		}
		return NULL;
	}

	public function get_search_results($search_string, $is_logged_in, $offset, $limit = 24) {
		$data = array();
		if($search_string != '') {
			$this->db->select('*')
					 ->like('LOWER(description)', strtolower($search_string))
					 ->order_by('id', 'DESC');
			$query = $this->db->get($this->table_name, $limit, $limit * $offset);
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $picture) {
					$pictures = array();

					$pictures['id'] = $picture->id;
					$pictures['path'] = $picture->picture;
					$pictures['description'] = $picture->description;
					
					$details = $this->get_picture_details($picture->id);
					$pictures['album_name'] = $details['album_name'];
					$pictures['username'] = $details['username'];
					$pictures['complete_name'] = $details['complete_name'];
					
					if ($is_logged_in) {
						$records = $this->get_picture_records($picture->id);
						$pictures['comments'] = $records['comments'];
						$pictures['likes'] = $records['likes'];

						$pictures['is_liked'] = $this->is_liked_by_user($picture->id);
					}
					array_push($data, $pictures);
				}
			}
		}
		return $data;
	}
}