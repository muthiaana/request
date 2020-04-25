<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Core_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function Forbidden403(){
		$data['title'] = 'Access Forbidden';
		$this->load->view('errors/error_403', $data);
	}

	public function Notfound404(){
		$data['title'] = 'Page Not Found';
		$this->load->view('errors/error_404', $data);
	}

}

/* End of file Error.php */
/* Location: ./application/controllers/Error.php */