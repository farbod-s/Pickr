<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Picture_Album extends CI_Model
{
	private $table_name = 'picture_album';
	private $user_album_table_name = 'user_album';
	private $picture_table_name = 'picture';
	private $album_table_name = 'album';
	private $follow_table_name = 'follow';
	private $comment_table_name = 'comment';
	private $feel_table_name = 'feel';
	private $users_table_name = 'users';

	function __construct() {
		parent::__construct();
	}

	// add picture to album
	public function add_picture_to_album($user_id, $picture_id, $album_name, $description) {
		$picture_path = $this->get_picture_path($picture_id);
		$album_id = $this->get_album_id($user_id, $album_name);
		if ($picture_id && $album_id && $picture_path) {
			$data['picture'] = $picture_path;
			$data['added'] = date('Y-m-d H:i:s');
			$data['description'] = $description;
			if ($this->db->insert($this->picture_table_name, $data)) {
				$new_data['picture_id'] = $this->db->insert_id();
				$new_data['album_id'] = $album_id;
				if ($this->db->insert($this->table_name, $new_data)) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	private function get_picture_path($picture_id) {
		$this->db->where('id', $picture_id);
		$query = $this->db->get($this->picture_table_name);
		if ($query->num_rows() > 0) {
			return $query->row()->picture;
		}
		return NULL;
	}

	private function get_picture_id($picture_path) {
		$pic_id = 0;
		$this->db->where('picture', $picture_path);
		$query = $this->db->get($this->picture_table_name);
		if ($query->num_rows() > 0) {
			$pic_id = $query->row()->id;
		}
		return $pic_id;
	}

	private function get_album_id($user_id, $album_name) {
		$all_album_id = $this->get_all_album_id($user_id);
		$album_id = 0;
		$this->db->where('name', $album_name);
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (in_array($row->id, $all_album_id)) {
					$album_id = $row->id;
					return $album_id;
				}
			}
		}
		return $album_id;
	}

	private function get_all_album_id($user_id) {
		$albums_id = array();
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		foreach ($query->result() as $row) {
			array_push($albums_id, $row->album_id);
		}
		return $albums_id;
	}

	public function count_followed_pictures($followed_albums) {
		$count = 0;
		foreach($followed_albums as $album_id) {
			$this->db->where('album_id' , $album_id);
			$query = $this->db->count_all_results($this->table_name);
			$count += $query;
		}		
		return $count;
	}

	public function get_picture_count($user_id, $album_name) {
		$albums_id = array();
		$this->db->select('*');
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $album) {
		        if ($album_name == preg_replace("![^a-z0-9_]+!i", "-", strtolower($album->name))) {
		        	array_push($albums_id, $album->id);
		        }
		    }
		}
		$album_id = 0;
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (in_array($row->album_id, $albums_id)) {
					$album_id = $row->album_id;
					break;
				}
			}
		}
		$counts = 0;
		$this->db->where('album_id', $album_id);
		$counts = $this->db->count_all_results($this->table_name);
        return $counts;
	}

	public function get_follow_count($user_id, $album_name) {
		$albums_id = array();
		$this->db->select('*');
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $album) {
		        if ($album_name == preg_replace("![^a-z0-9_]+!i", "-", strtolower($album->name))) {
		        	array_push($albums_id, $album->id);
		        }
		    }
		}
		$album_id = 0;
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (in_array($row->album_id, $albums_id)) {
					$album_id = $row->album_id;
					break;
				}
			}
		}
		$counts = 0;
		$this->db->where('album_id', $album_id);
		$counts = $this->db->count_all_results($this->follow_table_name);
        return $counts;
	}

	public function get_album_pictures($user_id, $album_name, $me, $offset, $limit = 24) {
		$albums_id = array();
		$this->db->select('*');
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $album) {
		        if ($album_name == preg_replace("![^a-z0-9_]+!i", "-", strtolower($album->name))) {
		        	array_push($albums_id, $album->id);
		        }
		    }
		}
		$album_id = 0;
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (in_array($row->album_id, $albums_id)) {
					$album_id = $row->album_id;
					break;
				}
			}
		}
		$pictures_id = array();
		$this->db->where('album_id', $album_id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				array_push($pictures_id, $row->picture_id);
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
				$pictures['album_name'] = $this->get_album_name($album_id);
				$pictures['username'] = $details['username'];
				$pictures['complete_name'] = $details['complete_name'];
				
				$records = $this->get_picture_records($query->row()->id);
				$pictures['comments'] = $records['comments'];
				$pictures['likes'] = $records['likes'];
				if (!$me) {
					$pictures['is_liked'] = $this->is_liked_by_user($query->row()->id);
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
		$details['username'] = '';
		$details['complete_name'] = '';
		$this->db->where('picture_id', $picture_id);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) {
			$album_id = $query->row()->album_id;
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

	public function delete_pic($user_id, $picture_id, $album_name) {
		$album_id = $this->get_album_id_from_url($user_id, $album_name);
		if ($picture_id && $album_id) {
			$this->db->where('picture_id', $picture_id);
			$this->db->delete($this->feel_table_name);

			$this->db->where('picture_id', $picture_id);
			$this->db->delete($this->comment_table_name);
		
			$this->db->where('picture_id', $picture_id);
			$this->db->where('album_id', $album_id);
			$this->db->delete($this->table_name);
			if ($this->db->affected_rows() > 0) {
				$this->db->where('id', $picture_id);
				$this->db->delete($this->picture_table_name);
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}
		return FALSE;
	}

	private function get_album_id_from_url($user_id, $album_name) {
		$albums_id = array();
		$this->db->select('*');
		$query = $this->db->get($this->album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $album) {
		        if ($album_name == preg_replace("![^a-z0-9_]+!i", "-", strtolower($album->name))) {
		        	array_push($albums_id, $album->id);
		        }
		    }
		}
		$final_album_id = 0;
		$user_albums_id = $this->get_all_album_id($user_id);
		foreach ($user_albums_id as $album_id) {
			if (in_array($album_id, $albums_id)) {
				$final_album_id = $album_id;
				return $final_album_id;
			}
		}
		return $final_album_id;
	}

	public function get_user_pick_count($user_id) {
		$counts = 0;
		$albums_id = array();
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				array_push($albums_id, $row->album_id);
			}
		}
		if (count($albums_id) > 0) {
			foreach ($albums_id as $album_id) {
				$this->db->where('album_id', $album_id);
				$counts += $this->db->count_all_results($this->table_name);
			}
		}
        return $counts;
	}
}