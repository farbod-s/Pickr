<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class follow extends CI_Model
{
	private $table_name = 'follow';
	private $album_table_name = 'album';
	private $picture_table_name = 'picture';
	private $users_table_name = 'users';
	private $user_album_table_name = 'user_album';
	private $picture_album_table_name = 'picture_album';
	private $comment_table_name = 'comment';
	private $feel_table_name = 'feel';

	function __construct() {
		parent::__construct();
	}

	public function get_followed_pictures($user_id, $offset, $limit = 24) {
		$albums_id = array();
		$this->db->where('user_id', $user_id);
		$query= $this->db->get($this->table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $id) {
	        	array_push($albums_id, $id->album_id);
	        }
	    }
	    $pictures_id = array();
	    foreach($albums_id as $album_id) {
			$this->db->where('album_id' , $album_id);
			$query = $this->db->get($this->picture_album_table_name);
			if ($query->num_rows() > 0) {
				foreach($query->result() as $pic){
					array_push($pictures_id, $pic->picture_id);
				}
			}
		}
		sort($pictures_id, SORT_NUMERIC);
		$start = $offset * $limit;
		$end = $start + $limit;
		$size = count($pictures_id);
		$data = array();
		for ($i = $start; $i <= min($end, $size - 1); $i++) {
			$this->db->where('id', $pictures_id[$size - 1 - $i]);					
			$query = $this->db->get($this->picture_table_name);
			if ($query->num_rows() == 1) {
				$pictures = array();

				$pictures['id'] = $query->row()->id;
				$pictures['path'] = $query->row()->picture;
				$pictures['description'] = $query->row()->description;
				
				$details = $this->get_picture_details($query->row()->id);
				$pictures['album_name'] = $details['album_name'];
				$pictures['username'] = $details['username'];
				$pictures['complete_name'] = $details['complete_name'];
				
				$records = $this->get_picture_records($query->row()->id);
				$pictures['comments'] = $records['comments'];
				$pictures['likes'] = $records['likes'];
				$pictures['is_liked'] = $this->is_liked_by_user($query->row()->id);
				
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

	public function get_followed_ids($user_id){
		$albums_id = array();
		$this->db->where('user_id', $user_id);
		$query= $this->db->get($this->table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $id) {
	        	array_push($albums_id, $id->album_id);
	        }
	    return $albums_id;
	    }
	    else {
	    	$albums_id = array("0","0");
	    	return $albums_id;
		}
	}

	public function insert_follow($user_id,$album_id) {
		$data = array (
			'user_id' => $user_id,
			'album_id' => $album_id
		);
		$this->db->insert($this->table_name,$data);
	}

	public function delete_follow($user_id,$album_id) {
		$this->db->where('user_id', $user_id);
		$this->db->where('album_id', $album_id);
		$this->db->delete($this->table_name);
	}

	public function insert_follow_all($user_id,$album_ids) {
		foreach ($album_ids as $id) {
			$data = array (
				'user_id' => $user_id,
				'album_id' => $id
			);
			$this->db->insert($this->table_name,$data);			
		}
	}

	public function delete_follow_all($user_id,$album_ids) {
		foreach ($album_ids as $id) {
			$this->db->where('user_id', $user_id);
			$this->db->where('album_id', $id);
			$this->db->delete($this->table_name);
		}
	}

	public function is_person_followed($user_id,$album_ids) {
		$albums_id = array();
		$this->db->where('user_id', $user_id);
		$query= $this->db->get($this->table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $id) {
	        	array_push($albums_id, $id->album_id);
	        }
	    }
	    else {
	    	$albums_id = array("0","0");
		}		
		foreach ($album_ids as $id){
			if(!in_array($id , $albums_id)){
				return FALSE;
			}
		}
		return TRUE;
	}

}