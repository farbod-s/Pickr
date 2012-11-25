<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Picture_Album extends CI_Model
{
	private $table_name = 'picture_album';

	function __construct() {
		parent::__construct();
	}

	// add picture to album
	public function add_picture_to_album($picture_path, $album_name) {
		$picture_id = $this->ci->picture->get_picture_id($picture_path);
		$album_id = $this->ci->album->get_album_id($album_name);

		if ($picture_id && $album_id) {
			$this->db->set('picture_id', $picture_id);
			$this->db->set('album_id', $album_id);
			$this->db->insert($this->table_name);

			return TRUE;
		}

		return FALSE;
	}
}