<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RequestIT_Model extends CI_Model {

	var $table = "ecrm_request_it";

	function add($katmasalah){
		$this->db->insert($this->table,$katmasalah);

		if ($this->db->affected_rows()>0) {
			redirect('Request/show_list_requestit');
		}
	}
	public function update($namauser, $data)
	{
		$this->db->where('username',$namauser);
		$this->db->update($this->table,$data);
		if ($this->db->affected_rows()>0) {
			redirect('Request/show_list_requestit');
		}
	}

	public function get_requestit()
	{
		$this->db->select('*')->from(' ecrm_request_it');
		$res = $this->db->get();

		return $res->result();
	}


	public function delete_requestit($NoTiket)
	{
		$this->db->where('NoTiket',$NoTiket);
		$this->db->delete('ecrm_request_it');

		if ($this->db->affected_rows()>0) {
			redirect('Request/show_list_requestit');
		}
	}


	public function get_requestit_detail($notiket)
	{
		$this->db->select('*')->from(' ecrm_request_it');
		$this->db->where('NoTiket',$notiket);
		$res = $this->db->get();
		return $res->result();
	}


	public function get_request()
	{
		$this->db->select('*')
				->from('ecrm_request_it');
		$res = $this->db->get();

		return $res->result();
	}
	
	public function get_role()
	{
		$this->db->select('*')
				->from('ecrm_user_role');
		$res = $this->db->get();

		return $res->result();
	}


	public function finish_requestIT($NoTiket)
	{


		$this->db->where('NoTiket', $NoTiket);
		$this->db->update($this->table, ['Status' => 'Sudah Dikerjakan','Finished_at' => date("Y-m-d H:i:s")]); 
		if ($this->db->affected_rows()>0) 
		{
			redirect('Request/show_list_requestit');
		}
	}


	public function start_requestIT($NoTiket){

		$this->db->where('NoTiket', $NoTiket);
		$this->db->update($this->table, [
			'Status' => 'Sedang Dikerjakan',
			'Started_at' =>  date("Y-m-d H:i:s"),
			'idIT' => $this->session->userdata('username'),
		]); 
		if ($this->db->affected_rows()>0) 
		{
			redirect('Request/show_list_requestit');
		}
	}


	public function get_user_by_role()
	
	{
		$this->db->select('*')
				->from('ecrm_users')
				->join('ecrm_user_role','ecrm_user_role.id_role=ecrm_users.id_role')
				->where('ecrm_user_role.id_role !=','user');
				
		$res = $this->db->get();

		return $res->result();
	}




}

