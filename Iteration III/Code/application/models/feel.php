<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Model
{
	private $table_name = 'feel'; //feel_table{picture_id  , user_id}

	function __construct() {
		parent::__construct();
	}
	public  function get_count_like($picture_id)
	{
		$items = $this->db->select('COUNT(picture_id) AS count', false)
                  ->from($table_name)
                  ->where('picture_id',$picture_id)
                  ->group_by('picture_id')
                  ->get()->result();

        return $items;
	}

	public  function save_like($picture_id , $user_id)
	{
		$data_array = array('user_id' =>$user_id ,'picture_id'=>$picture_id );
		$this->db->insert($table_name,$data_array);
	}

	public function dalete_like($picture_id , $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('picture_id', $picture_id);
		$this->db->delete($table_name); 
	}
	
}