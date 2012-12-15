<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Model
{
	private $table_name = 'album';
	private $user_album_table_name = 'user_album';
	private $picture_table_name = 'picture';
	private $picture_album_table_name = 'picture_album';

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

	public function get_albums_detail($user_id) {
		/*
		$first_pic = array();
		$temp = array();
		// find albums by user_id from user_album table
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		// for every founded album
		foreach ($query->result() as $albums_id) {
			// find first picture_id from picture_album table
			$this->db->select_min('picture_id');
			$query2= $this->db->get_where($this->picture_album_table_name,array('album_id' => $albums_id->album_id));
			// push first pics into an array
			if ($query2->num_rows() > 0) {
				foreach ($query2->result() as $pics_id) {
					array_push($temp, $pics_id->picture_id);
				}
			}
		}
		// for every founded picture_id
		foreach ($temp as $pic_id){
			// find the picture field (picture address) from picture table
			$this->db->where('id', $pic_id);
			$query3 = $this->db->get($this->picture_table_name);
			//push first pics's addresses into an array
			if ($query3->num_rows() > 0) {
				foreach ($query3->result() as $pic) {
					array_push($first_pic, $pic->picture);
				}
			}
		}
		return $first_pic;
		*/

		$detail = array();
		$this->db->where('user_id', $user_id);
		$query = $this->db->get($this->user_album_table_name);
		foreach($query->result() as $row) {
			$this->db->where('id', $row->album_id);
			$query2 = $this->db->get($this->table_name);
			if ($query2->num_rows() > 0) {
				$album_name = $query2->row()->name;
				$this->db->where('album_id', $row->album_id);
				$temp = $this->db->get($this->picture_album_table_name);
				if ($temp->num_rows() > 0) {
					$this->db->where('id', $temp->row()->picture_id);
					$picture_address = $this->db->get($this->picture_table_name);
					if ($picture_address->num_rows() > 0) {
						$detail[$album_name] = $picture_address->row()->picture;
					}
				}
				else {
					$detail[$album_name] = base_url(IMAGES.'upload_picture.png');
				}
			}
		}
		return $detail;
	}	
}