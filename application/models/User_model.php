<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{
  public $table = "ecrm_users";


  function add($iduser){
    $this->db->insert($this->table,$iduser);

    if ($this->db->affected_rows()>0) {
      redirect('NewUser/show_list_users','refresh');
    }
  }
  public function update($namauser, $data)
  {
    $this->db->where('username',$namauser);
    $this->db->update($this->table,$data);
    if ($this->db->affected_rows()>0) {
      redirect('NewUser/show_list_users');
    }
  }

  public function get_newuser()
  {
    $this->db->select('*')->from('ecrm_users');
    $res = $this->db->get();

    return $res->result();  
  }

  public function delete_newuser($username)
  {
    $this->db->where('id_user',$username);
    $this->db->delete('ecrm_users');

    if ($this->db->affected_rows()>0) {
      redirect('NewUser/show_list_users','refresh');
    }
  }
    public function get_newuser_detail($namauser)
  {
    $this->db->select('*')->from('ecrm_users');
    $this->db->where('username',$namauser);
    $res = $this->db->get();
    return $res->result();
  }


}

