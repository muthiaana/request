<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriMasalah_Model extends CI_Model {
	var $table = "ecrm_kategori_masalah";

	function add($idkatmasalah){
		$this->db->insert($this->table,$idkatmasalah);

		if ($this->db->affected_rows()>0) {
			redirect('KategoriMasalah/show_list_masalah');
		}
	}
	public function update($katmasalah, $data)
	{
		$this->db->where('id_kat_masalah',$katmasalah);
		$this->db->update($this->table,$data);
		if ($this->db->affected_rows()>0) {
			redirect('KategoriMasalah/show_list_masalah');
		}
	}

	public function get_masalah()
	{
		$this->db->select('*')->from('ecrm_kategori_masalah');
		$res = $this->db->get();

		return $res->result();
	}

	public function delete_masalah($idkat)
	{
		$this->db->where('id_kat_masalah',$idkat);
		$this->db->delete('ecrm_kategori_masalah');

		if ($this->db->affected_rows()>0) {
			redirect('KategoriMasalah/show_list_masalah');


		}
	}
		public function get_masalah_detail($idkatmasalah)
	{
		$this->db->select('*')->from('ecrm_kategori_masalah');
		$this->db->where('id_kat_masalah',$idkatmasalah);
		$res = $this->db->get();
		return $res->result();
	}


}

