<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Model
{
	private $table_name = 'comment'; // comment_tbl { picture_id, user_id, date, comment }

	function __construct() {
		parent::__construct();
	}


	public function load_all_comments($picture_id)
	{
		$comments = array();
		$this->db->select('*')->from($table_name)->where('picture_id', $picture_id)->order_by('date', 'DESC')->limit(5);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $comment) {
                $comments['user_id'] = $comment->user_id;
                $comments['picture_id'] = $comment->picture_id;
                $comments['date'] = $comment->date;
                $comments['comment'] = $comment->comment;
            }
		}

		return $comments;
	}

	public function insert_comments($comment , $picture_id , $user_id)
	{
		$data_array = array('user_id' =>$user_id ,'picture_id'=>$picture_id ,'date'=> date('Y-m-d H:i:s') , 'comment'=>$comment);
		$this->db->insert($table_name,$data_array);
	}

	public function delete_comments($comment , $picture_id , $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('picture_id', $picture_id);
		$this->db->delete($table_name);
	}

}
