<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DaftarUser_model extends CI_Model {
	var $table = "user";

	function add($user){
		$this->db->insert($this->table,$user);

		if ($this->db->affected_rows()>0) {
			redirect('C_insertuser/index');
		}
	}
	public function update($namauser, $data)
	{
		$this->db->where('namauser',$namauser);
		$this->db->update($this->table,$data);
		if ($this->db->affected_rows()>0) {
			redirect('master/formuser');
		}
	}

	public function get_user()
	{
		$this->db->select('*')->from('user');
		$res = $this->db->get();

		return $res->result();
	}
	public function delete_user($iduser)
	{
		$this->db->where('iduser',$iduser);
		$this->db->delete('user');

		if ($this->db->affected_rows()>0) {
			redirect('C_InsertUser/show_list_user');
		}
	}
		public function get_user_detail($iduser)
	{
		$this->db->select('*')->from('user');
		$this->db->where('iduser',$iduser);
		$res = $this->db->get();
		return $res->result();
	}


}

