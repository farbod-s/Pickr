<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Picture extends CI_Model
{
	private $table_name = 'picture';

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

	public function get_public_pictures($limit){
		$pictures = array();
		$this->db->select('picture , id')
	 		 ->order_by('id', 'desc')
	  		 ->limit($limit['length'],$limit['start']);		
		$pics = $this->db->get($this->table_name);
		foreach($pics->result() as $pic){
			$address = $pic->picture;
			$pictures[$address] = $pic->id; 
		}
		return $pictures;
	}
}