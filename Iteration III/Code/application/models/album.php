<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Model
{
	private $table_name = 'album';
	private $user_album_table_name = 'user_album';

	function __construct() {
		parent::__construct();
	}

	// find album_id
	public function get_album_id($album_name) {
		$album_id = 0;
		$this->db->where('name', $album_name);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1) {
			$album_id = $query->row()->id;
		}

		return $album_id;
	}

	public function create_album($album_name, $user_id) {
		$data['name'] = $album_name;
		if ($this->db->insert($this->table_name, $data)) {
			$album_id = $this->db->insert_id();
			$this->db->set('user_id', $user_id);
			$this->db->set('album_id', $album_id);
			if ($this->db->insert($this->user_album_table_name)) {
				return true;
			}
		}

		return false;
	}

	// get all album_name
	public function get_all_album_name($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		if ($query->num_rows() > 0) {
			return $this->get_album_name($query);
		}

		return NULL;
	}

	private function get_album_name($query) {
		$albums_name = array();
		foreach ($query->result() as $albums_id) {
	        $this->db->where('id', $albums_id->album_id);
			$query2 = $this->db->get($this->table_name);
			if ($query2->num_rows() > 0) {
				foreach ($query2->result() as $album) {
	                array_push($albums_name, $album->name);
	            }
			}
	    }

	    return $albums_name;
	}
}