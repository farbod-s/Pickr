<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends MY_Controller {
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_render('pages/upload');
    }
}