<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Album extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
	}

	public function index() {
		show_404();
	}

	public function view($albumId = -1) {
		$this->data['data'] = array();
		$this->data['albumId'] = $albumId;
		if ($albumId != -1)
		{
			$this->ci = &get_instance();
			$this->ci->load->database();
			$this->ci->load->model('picture_album');
			$this->data['data'] = $this->picture_album->show_list($albumId);
			$this->data['albumname'] = $this->picture_album->show_name($albumId);
			
		}
		
		$this->_render('pages/album_view');
		
	}

	public function delete($albumId = -1) {
		
			$this->ci = &get_instance();
			$this->ci->load->database();
			$this->ci->load->model('picture_album');
			$this->picture_album->delete_album($albumId);
            redirect(base_url().'index.php/'.'album/view/'.$albumId);
	}

	public function rename($albumId = -1) {
		$newname = $this->input->get('newname', TRUE);
		$this->load->database();
		mysql_query("UPDATE album SET name= '$newname' where id=$albumId");
		redirect(base_url().'index.php/'.'album/view/'.$albumId);
	}
	
		public function deletepic($picId = -1,$albumId= -1) {
		
			$this->ci = &get_instance();
			$this->ci->load->database();
			$this->ci->load->model('picture_album');
			$this->picture_album->delete_pic($picId,$albumId);
            redirect(base_url().'index.php/'.'album/view/'.$albumId);
	}

	
}
