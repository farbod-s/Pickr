<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Picture_Album extends CI_Model
{
	private $table_name = 'picture_album';
	private $user_album_table_name = 'user_album';
	private $picture_table_name = 'picture';
	private $album_table_name = 'album';

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

	public function get_followed_pictures($followed_albums,$limit){
		$pictures = array(); 
		$temp = array();
		foreach($followed_albums as $album_id){
			$this->db->where('album_id' , $album_id)
					 ->order_by('id', 'desc');
			$query = $this->db->get($this->table_name);
			if ($query->num_rows() > 0) {
				foreach($query->result() as $pic){
					array_push($temp, $pic->picture_id);
				}
			}
		}/*
		for($i=$limit['start']; $i<$limit['start']+$limit['length']; $i++){
			$pic_id = $temp[$i];
			$this->db->where('id' , $pic_id);					
			$query = $this->db->get($this->picture_table_name);
			//array_push($pictures, $query->row()->picture);
			$pictures[$query->row()->picture] = $pic_id;
		}*/
		return $pictures;
	}

	public function get_album_pictures($user_id, $album_name) {
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
		$pictures = array();
		foreach ($pictures_id as $picture_id) {
			$this->db->where('id', $picture_id);
			$query = $this->db->get($this->picture_table_name);
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					array_push($pictures, array('id' => $row->id,
												'path' => $row->picture));
				}
			}
		}
		return $pictures;
	}

	public function delete_pic($user_id, $picture_id, $album_name) {
		$album_id = $this->get_album_id_from_url($user_id, $album_name);
		if ($picture_id && $album_id) {
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
}