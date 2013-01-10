<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_Model extends CI_Model
{
	private $picture_table_name = 'picture';
	private $album_table_name = 'album';
	private $user_album_table_name = 'user_album';
	private $picture_album_table_name = 'picture_album';
	private $user_profile_table_name = 'user_profiles';

	function __construct() {
		parent::__construct();
	}

	public function do_upload($user_id, $picture_path, $album_name, $description) {
		$album_name = preg_replace("![^a-z0-9_]+!i", "-", strtolower($album_name));
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
		if ($albums_id) {
			$all_albums_id = $this->get_all_album_id($user_id);
			if ($all_albums_id) {
				foreach ($all_albums_id as $album_id) {
					if (in_array($album_id, $albums_id)) {
						$final_album_id = $album_id;
						break;
					}
				}
			}
		}
		if ($final_album_id > 0) {
			$data['picture'] = $picture_path;
			$data['added'] = date('Y-m-d H:i:s');
			$data['description'] = $description;
			if ($this->db->insert($this->picture_table_name, $data)) {
				$picture_id = $this->db->insert_id();
				$new_data['picture_id'] = $picture_id;
				$new_data['album_id'] = $final_album_id;
				if ($this->db->insert($this->picture_album_table_name, $new_data)) {
					return TRUE;
				}
			}
		}
		return FALSE;
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

	public function upload_profile_picture($user_id, $picture_path) {
		$this->db->set('pic_address', $picture_path);
		$this->db->where('user_id', $user_id);
		$this->db->update($this->user_profile_table_name);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
}