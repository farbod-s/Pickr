<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feel extends CI_Model
{
	private $table_name = 'feel'; //feel_table{picture_id  , user_id}
	private $picture_table_name = 'picture';

	function __construct() {
		parent::__construct();
	}

	public  function get_count_like($picture_id)
	{
		$items = $this->db->select('COUNT(picture_id) AS count', FALSE)
                  ->from($this->table_name)
                  ->where('picture_id', $picture_id)
                  ->group_by('picture_id')
                  ->get()->result();

        return $items;
	}

	public function like($user_id, $picture_id) {
		if ($picture_id && $this->save_like($picture_id, $user_id)) {
			return TRUE;
		}
		return FALSE;
	}

	public function dislike($user_id, $picture_id) {
		if ($picture_id && $this->delete_like($picture_id, $user_id)) {
			return TRUE;
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

	private function save_like($picture_id, $user_id)
	{
		$data_array = array('user_id' => $user_id, 'picture_id' => $picture_id);
		if ($this->db->insert($this->table_name, $data_array)) {
			return TRUE;
		}
		return FALSE;
	}

	private function delete_like($picture_id, $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('picture_id', $picture_id);
		$this->db->delete($this->table_name);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}	
}