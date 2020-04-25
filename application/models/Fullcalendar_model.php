<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fullcalendar_model extends CI_Model {
	var $table = "ecrm_events";


	 function fetch_all_event(){
	  $this->db->order_by('id');
	  return $this->db->get('ecrm_events');
	 }

	function insert_event($data) {
	  $this->db->insert($this->table,$data);
	}

	function update_event($data, $id) {
	  $this->db->where('id', $id);
	  $this->db->update($this->table,$data);
	 }

	function delete_event($id){
	  $this->db->where('id', $id);
	  $this->db->delete('ecrm_events');
	}
}

?>
