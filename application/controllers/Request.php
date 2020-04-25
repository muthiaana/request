<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends Core_Controller {

	function __construct(){
		parent::__construct();
		$this->_Authorization();
		$this->load->model('M_model');
	}
  	
	public function index(){
		$data['title'] = 'Request IT Support';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['katmasalah'] = $this->db->get('ecrm_kategori_masalah')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('request_it/form', $data);
		$this->load->view('templates/footer');
	}


	public function submit() {
		$this->load->model('RequestIT_model');
		$table = 'ecrm_request_it';
		$fields = 'NoTiket';
		$inisial = 'RQ';

	 	$namauser = $this->input->post('NoTiket');
		if ($namauser =='') {
			$Tiket = makeID_inisial_dateReset($fields, $table, $inisial);
			$reqit = array(
				'NoTiket'=>$Tiket,
				'username' => $this->session->userdata('username'),
				// 'username' => $this->input->post('username'),
				'ketmasalah' => $this->input->post('ketmasalah'),
				'kategorimasalah' => $this->input->post('kategorimasalah'),
				'tanggal' => date('y-m-d H:i'),
				'prioritas' => $this->input->post('prioritas'),
				'Status' => 'Normal',
				'stok' => $this->input->post('stok'),
				'Started_at' => null,
				'Finished_at' => null,
				'idIT' => $this->input->post('idIT')
				// 'itsupport' => $this->input->post('itsupport'),
			);

		 	$this->RequestIT_model->add($reqit);
	 	}else {
		   $tglOn = $this->input->post('Started_at');
		   $tglOf = $this->input->post('Finished_at');
		  
		   if($this->input->post('Started_at') == '0000-00-00 00:00:00'){
		   	 $tglOn = nul;
		   }
		   if($this->input->post('Finished_at') == '0000-00-00 00:00:00'){
		   	 $tglOf = null;
		   }
			$data = array(
				// 'username' => $this->input->post('username'),
				'username' => $this->session->userdata('username'),
				'ketmasalah' => $this->input->post('ketmasalah'),
				'kategorimasalah' => $this->input->post('kategorimasalah'),
				'tanggal' => date('y-m-d H:i'),
				'prioritas' => $this->input->post('prioritas'),
				'Status' => $this->input->post('Status'),
				'stok' => $this->input->post('stok'),
				'Started_at' => date("Y-m-d H:i:s"),
				'Finished_at' => $tglOf,
				'idIT' => $this->input->post('idIT'),
			);
			$this->RequestIT_model->update($namauser, $data);
	 	}
		
	}

	
	public function show_list_requestit() {
		$data['title'] = "Request IT Support";
		$this->load->model('RequestIT_model');
		$data["request_it"] = $this->RequestIT_model->get_requestit();
		$username = $this->session->userdata('username');
		$id_role = $this->session->userdata('id_role');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['id_role'] = $this->db->get_where('ecrm_user_role', ['id_role' => $id_role])->row_array();
		$data['Request'] = $this->RequestIT_model->get_request();
		// $this->load->view('pelanggan/list_pelanggan',$data);
		// 
		$this->load->view('templates/header', $data);
		$this->load->view('request_it/list_reqit', $data);
		$this->load->view('templates/footer');
	}

	public function hapus_request()
	{
		$this->load->model('RequestIT_model');
		$NoTiket = $this->uri->segment(3);
		$this->RequestIT_model->delete_requestit($NoTiket);
	}

	public function edit_request()
	{
		$notiket = $this->uri->segment(3);
		$data['title'] = 'Request IT Support';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['katmasalah'] = $this->db->get('ecrm_kategori_masalah')->result_array();


		$this->load->model('RequestIT_model');
		$data['reqit'] = $this->RequestIT_model->get_requestit_detail($notiket);
		// $data['user'] = $this->RequestIT_model->get_user_by_role();

		$this->load->view('templates/header', $data);
		$this->load->view('request_it/edit', $data);
		$this->load->view('templates/footer');
		// $this->load->view('request_it/form',$data);
	}

	public function finish_request() 
	{	
		$this->load->model('RequestIT_Model');
		$NoTiket = $this->uri->segment(3);
		
		$this->RequestIT_Model->finish_requestIT($NoTiket);

	}


	public function start_request() 
	{	
		$this->load->model('RequestIT_Model');
		$NoTiket = $this->uri->segment(3);
		
		$this->RequestIT_Model->start_requestIT($NoTiket);

	}

	public function detail_request() 
	{		 
		$NoTiket = $this->uri->segment(3);
		$this->load->model('RequestIT_Model');
		$data["data_request"] = $this->RequestIT_Model->get_requestit_detail($NoTiket);
		$this->load->model('RequestIT_Model');
		$data["user"] = $this->RequestIT_Model->get_user();
		$data['page'] = "request_it/form";
		$this->load->view('main',$data);
		
	}

}