<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MY_Controller {
    function __construct() {
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) {
			redirect(base_url());
		}
    }

    public function index() {
        $this->_render('pages/upload');
    }

    public function upload_file() {
		$status = "";
		$msg = "";
		$picture_path = base_url(IMAGES.'upload_picture.png');
		$file_element_name = 'userfile';
		if (!$this->input->post('album_name')) {
			$status = "error";
			$msg = "Please enter a title";
		}
		if ($status != "error") {
			$config['upload_path'] = './resources/upload';
			$config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';
			$config['max_size']  = 1024 * 8;
			/*$config['max_width'] = '';
			$config['max_height'] = '';*/
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name)) {
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			}
			else {
				$data = $this->upload->data();
				$this->ci =& get_instance();
				$this->ci->load->database();
				$this->ci->load->model('upload_model');
				$user_id = $this->ci->session->userdata('user_id');
				if($this->upload_model->do_upload($user_id,
												  base_url(UPLOAD.$data['file_name']),
												  $this->input->post('album_name'),
												  $this->input->post('description'))) {
					$status = "success";
					$msg = "File successfully uploaded";
					$picture_path = base_url(UPLOAD.$data['file_name']);
				}
				else {
					unlink($data['full_path']);
					$status = "error";
					$msg = "Something went wrong when saving the file, please try again.";
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
		echo json_encode(array('status' => $status,
							   'msg' => $msg,
							   'picture_path' => $picture_path));
    }
}