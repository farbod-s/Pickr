<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class follow extends CI_Model
{
	private $table_name = 'follow';

	function __construct() {
		parent::__construct();
	}

	public function insert_follow($user_id,$album_id) {
		$data = array (
			'user_id' => $user_id,
			'album_id' => $album_id
		);
		$this->db->insert($this->table_name,$data);
	}

	public function delete_follow($user_id,$album_id)
	{
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

	public function delete_follow_all($user_id,$album_ids)
	{
		foreach ($album_ids as $id) {
			$this->db->where('user_id', $user_id);
			$this->db->where('album_id', $id);
			$this->db->delete($this->table_name);
		}
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

	public function is_person_followed($user_id,$album_ids){
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