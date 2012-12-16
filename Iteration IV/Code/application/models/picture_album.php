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
	public function add_picture_to_album($user_id, $picture_path, $album_name, $description) {
		$picture_id = $this->get_picture_id($picture_path);
		$album_id = $this->get_album_id($user_id, $album_name);
		if ($picture_id && $album_id) {
			$data['picture_id'] = $picture_id;
			$data['album_id'] = $album_id;
			$data['description'] = $description;
			$data['added'] = date('Y-m-d H:i:s');
			if ($this->db->insert($this->table_name, $data)) {
				return TRUE;
			}
		}
		return FALSE;
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
	
	public function show_list($album_id) {
		$this->db->select('picture_id'); 
		$this->db->from('picture_album');   
		$this->db->where('album_id', $album_id);
		return $this->db->get()->result();
	}
		
	public function delete_album ($albumId)
	{
		$this->db->where('id', $albumId);
		$this->db->delete('album');  
		$this->db->where('album_id', $albumId);
		$this->db->delete('picture_album'); 
		return;
	}
	public function show_name($album_id){
		$this->db->select('name'); 
		$this->db->from('album');   
		$this->db->where('id', $album_id);
		return $this->db->get()->result();
	}

	public function delete_pic ($picId,$albumId)
	{
		$this->db->where('album_id', $albumId and 'picture_id',$picId);
		$this->db->delete('picture_album'); 
		return;
	}
		
		
}