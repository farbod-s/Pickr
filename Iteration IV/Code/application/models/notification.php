<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Model
{
	private $notification_table = 'notification';
	
	function __construct() {
		parent::__construct();
	}

	public function load_notifications($user_id) {
		$notifications = array();
		$this->db->select('*')
				 ->from($this->notification_table)
				 ->where('user_id', $user_id)
				 ->order_by('date', 'DESC')
				 ->limit(15);
		$query = $this->db->get();
		if($query->num_rows()> 0) {
			foreach($query->result() as $notification) {
				$detail = array();
				$detail['date'] = $notification->date;
				$detail['description'] = $notification->description;
				array_push($notifications, $detail);
			}
		}
		return $notifications;
	}

	public function add_pick_notification($user_id, $picture_id) {

	}

	public function add_like_notification($user_id, $picture_id) {

	}

	public function add_comment_notification() {

	}

	public function add_follow_notification() {

	}

	public function add_follow_all_notification() {

	}

	// *************************************************************
	// Get username by user_id
	private function get_username($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get($this->users_table_name);
		if ($query->num_rows() == 1) return $query->row()->username;
		return NULL;
	}

	public function add_comment_to_picture($user_id, $picture_path, $comment) {
		$picture_id = $this->get_picture_id($picture_path);
		if ($this->insert_comment($comment, $picture_id, $user_id)) {
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
