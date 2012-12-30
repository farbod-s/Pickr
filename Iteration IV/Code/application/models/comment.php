<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Model
{
	private $table_name = 'comment'; // comment_tbl { picture_id, user_id, date, comment }
	private $picture_table_name = 'picture';
	private $users_table_name = 'users';

	function __construct() {
		parent::__construct();
	}

	public function load_all_comments($picture_id)
	{
		//$picture_id = $this->get_picture_id($picture_path);
		$comments = array();
		$this->db->select('*')
				 ->from($this->table_name)
				 ->where('picture_id', $picture_id)
				 ->order_by('date', 'DESC')
				 ->limit(5);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $comment) {
				$detail = array();
                $detail['username'] = $this->get_username($comment->user_id);
                $detail['date'] = $comment->date;
                $detail['comment'] = $comment->comment;
                array_push($comments, $detail);
            }
		}
		return $comments;
	}

	// Get username by user_id
	private function get_username($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get($this->users_table_name);
		if ($query->num_rows() == 1) return $query->row()->username;
		return NULL;
	}

	public function add_comment_to_picture($user_id, $picture_id, $comment) {
		//$picture_id = $this->get_picture_id($picture_path);
		if ($picture_id && $this->insert_comment($comment, $picture_id, $user_id)) {
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

	private function insert_comment($comment, $picture_id, $user_id)
	{
		$data_array = array('user_id' => $user_id,
							'picture_id' => $picture_id,
							'date' => date('Y-m-d H:i:s'),
							'comment' => $comment);
		if ($this->db->insert($this->table_name, $data_array)) {
			return TRUE;
		}
		return FALSE;
	}

	private function delete_comment($picture_id, $user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('picture_id', $picture_id);
		$this->db->delete($this->table_name);
	}
}
