<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core_Model extends CI_Model
{

	protected $table_name;

	public function __construct() {
		parent::__construct();
	}

	public function insert($data = null) {
		if ($data != null) {
			$this->db->insert($this->table_name, $data);
		}
	}

	public function update($data = null, $criteria = null) {
		
		if ($data != null && $criteria != null) {
			$this->db->update($this->table_name, $data, $criteria);
		}
	}

	public function delete($criteria = null) {
		if ($criteria != null) {
			$this->db->delete($this->table_name, $criteria);
		}
	}

	public function get_all($offset = -1, $count = -1,$where=null,$or_where=null) {
		if ($offset != -1 && $count != -1) {
			$this->db->limit($count, $offset);
		}
		if ($where != null) {
			$this->db->where($where);
		}
		if($or_where!=null){$this->db->or_where($or_where);}
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get($this->table_name);
		return $query->result();
	}

	public function count_all($data=null,$or_where=null) {
		if($data!=null){$this->db->where($data);}
		if($or_where!=null){$this->db->or_where($or_where);}
		return $this->db->count_all($this->table_name);
	}
	

	public function get_by_criteria($where = null, $like = null, $offset = -1, $count = -1, $join = null, $order = null) {
		if ($offset != -1 && $count != -1) {
			$this->db->limit($count, $offset);
		}

		if (!is_null($where)) {
			$this->db->where($where);
        } else if (!is_null($like)) {
            //$this->db->like($like[0], $like[1]);
	    $this->db->like($like); 
		}

        if (!is_null($join)) {
            if (isset($join[2])) {
                $this->db->join($join[0], $join[1], $join[2]);
            } else {
                $this->db->join($join[0], $join[1]);
            }
        }

        if (!is_null($order)) {
            $this->db->order_by($order[0], $order[1]);
        }
        $this->db->order_by("id", "desc"); 
		$query = $this->db->get($this->table_name);
//        var_dump($this->db->last_query());
		return $query->result();
	}

	public function count_by_criteria($where = null, $like = null, $join = null) {
		if (!is_null($where)) {
			$this->db->where($where);
		} else if (!is_null($like)) {
			$this->db->like($like); 
            //$this->db->like($like[0], $like[1]);
		}

        if (!is_null($join)) {
            if (isset($join[2])) {
                $this->db->join($join[0], $join[1], $join[2]);
            } else {
                $this->db->join($join[0], $join[1]);
            }
        }

        $this->db->from($this->table_name);        
		return $this->db->count_all_results();
	}

}
