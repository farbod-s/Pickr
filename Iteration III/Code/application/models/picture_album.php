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
	
	public function show_list($album_id){
			 $this->db->select('picture_id'); 
   			 $this->db->from('picture_album');   
			 $this->db->where('album_id', $album_id);
 			 return $this->db->get()->result();
		}
		
		public function delete_album ($albumId)
		{
			$this->db->where('id', $albumId);
			$this->db->delete('album');  
			$this->db->where('album_id', $albumId);
			$this->db->delete('picture_album'); 
			return;
		}
		public function show_name($album_id){
			 $this->db->select('name'); 
   			 $this->db->from('album');   
			 $this->db->where('id', $album_id);
 			 return $this->db->get()->result();
		}
		
			public function delete_pic ($picId,$albumId)
		{
			$this->db->where('album_id', $albumId and 'picture_id',$picId);
			$this->db->delete('picture_album'); 
			return;
		}
		
		
}