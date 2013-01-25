<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Model
{
	private $notification_table = 'notification';
	private $users_table = 'users';
	private $album_table = 'album';
	private $user_album_table = 'user_album';
	private $picture_album_table = 'picture_album';
	
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

	public function add_pick_notification($subject_user_id, $picture_id) {
		$this->db->select('album_id')
				 ->from($this->picture_album_table)
				 ->where('picture_id', $picture_id);
		$album_id_query = $this->db->get();
		if($album_id_query->num_rows() != 1) {
			return FALSE;
		}
		$album_id = $album_id_query->row()->album_id;

		$this->db->select('user_id')
				 ->from($this->user_album_table)
				 ->where('album_id', $album_id);
		$object_user_id_query = $this->db->get();
		if($object_user_id_query->num_rows() != 1) {
			return FALSE;
		}
		$object_user_id = $object_user_id_query->row()->user_id;

		$this->db->select('username')
				 ->from($this->users_table)
				 ->where('id', $subject_user_id);
		$subject_username_query = $this->db->get();
		if($subject_username_query->num_rows() != 1) {
			return FALSE;
		}
		$subject_username = $subject_username_query->row()->username;

		$new_notification = array('date' => date('Y-m-d H:i:s'),
								  'description' => $subject_username.' picked one of your pictures.',
							      'user_id' => $object_user_id);
		if(!$this->db->insert($this->notification_table, $new_notification)) {
			return FALSE;
		}

		return TRUE;
	}

	public function add_like_notification($subject_user_id, $picture_id) {		
		$this->db->select('album_id')
				 ->from($this->picture_album_table)
				 ->where('picture_id', $picture_id);
		$album_id_query = $this->db->get();
		if($album_id_query->num_rows() != 1) {
			return FALSE;
		}
		$album_id = $album_id_query->row()->album_id;

		$this->db->select('user_id')
				 ->from($this->user_album_table)
				 ->where('album_id', $album_id);
		$object_user_id_query = $this->db->get();
		if($object_user_id_query->num_rows() != 1) {
			return FALSE;
		}
		$object_user_id = $object_user_id_query->row()->user_id;

		$this->db->select('username')
				 ->from($this->users_table)
				 ->where('id', $subject_user_id);
		$subject_username_query = $this->db->get();
		if($subject_username_query->num_rows() != 1) {
			return FALSE;
		}
		$subject_username = $subject_username_query->row()->username;

		$new_notification = array('date' => date('Y-m-d H:i:s'),
								  'description' => $subject_username.' liked one of your pictures.',
							      'user_id' => $object_user_id);
		if(!$this->db->insert($this->notification_table, $new_notification)) {
			return FALSE;
		}

		return TRUE;
	}

	public function add_comment_notification($subject_user_id, $picture_id) {
		$this->db->select('album_id')
				 ->from($this->picture_album_table)
				 ->where('picture_id', $picture_id);
		$album_id_query = $this->db->get();
		if($album_id_query->num_rows() != 1) {
			return FALSE;
		}
		$album_id = $album_id_query->row()->album_id;

		$this->db->select('user_id')
				 ->from($this->user_album_table)
				 ->where('album_id', $album_id);
		$object_user_id_query = $this->db->get();
		if($object_user_id_query->num_rows() != 1) {
			return FALSE;
		}
		$object_user_id = $object_user_id_query->row()->user_id;

		$this->db->select('username')
				 ->from($this->users_table)
				 ->where('id', $subject_user_id);
		$subject_username_query = $this->db->get();
		if($subject_username_query->num_rows() != 1) {
			return FALSE;
		}
		$subject_username = $subject_username_query->row()->username;

		$new_notification = array('date' => date('Y-m-d H:i:s'),
								  'description' => $subject_username.' commented on your picture.',
							      'user_id' => $object_user_id);
		if(!$this->db->insert($this->notification_table, $new_notification)) {
			return FALSE;
		}

		return TRUE;
	}

	public function add_follow_notification($subject_user_id, $album_id) {
		$this->db->select('name')
				 ->from($this->album_table)
				 ->where('id', $album_id);
		$album_name_query = $this->db->get();
		if($album_name_query->num_rows() != 1) {
			return FALSE;
		}
		$album_name = $album_name_query->row()->name;

		$this->db->select('user_id')
				 ->from($this->user_album_table)
				 ->where('album_id', $album_id);
		$object_user_id_query = $this->db->get();
		if($object_user_id_query->num_rows() != 1) {
			return FALSE;
		}
		$object_user_id = $object_user_id_query->row()->id;

		$this->db->select('username')
				 ->from($this->users_table)
				 ->where('id', $subject_user_id);
		$subject_username_query = $this->db->get();
		if($subject_username_query->num_rows() != 1) {
			return FALSE;
		}
		$subject_username = $subject_username_query->row()->username;
	
		$new_notification = array('date' => date('Y-m-d H:i:s'),
								  'description' => $subject_username.' started following your album "'.$album_name.'".',
							      'user_id' => $object_user_id);
		if(!$this->db->insert($this->notification_table, $new_notification)) {
			return FALSE;
		}

		return TRUE;
	}

	public function add_follow_all_notification($subject_user_id, $object_username) {
		$this->db->select('id')
				 ->from($this->users_table)
				 ->where('username', $object_username);
		$object_user_id_query = $this->db->get();
		if($object_user_id_query->num_rows() != 1) {
			return FALSE;
		}
		$object_user_id = $object_user_id_query->row()->id;

		$this->db->select('username')
				 ->from($this->users_table)
				 ->where('id', $subject_user_id);
		$subject_username_query = $this->db->get();
		if($subject_username_query->num_rows() != 1) {
			return FALSE;
		}
		$subject_username = $subject_username_query->row()->username;

		$new_notification = array('date' => date('Y-m-d H:i:s'),
								  'description' => $subject_username.' started following your albums.',
							      'user_id' => $object_user_id);
		if(!$this->db->insert($this->notification_table, $new_notification)) {
			return FALSE;
		}

		return TRUE;
	}
}