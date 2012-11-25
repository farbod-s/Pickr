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
		if ($query->num_rows() == 1) {
			$pic_id = $query->row()->id;
		}

		return $pic_id;
	}
}