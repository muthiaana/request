<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_model extends Core_Model {
// class M_wsbangun extends CI_Model {

	public function __construct() {
		parent::__construct();
        $this->load->database();
	}

    public function getDatatable($table='', $param='', $order='', $filter=''){
        $this->load->database();
        $result='';

        $sql_data = " SELECT * FROM ".$table;
        if (!empty($param)) {
            $sql_data.=" ".$param." " ;
        }
        if (!empty($filter)) {
            $sql_data.=" ".$filter." " ;
        }
        if (!empty($order)) {
            $sql_data.=" ".$order." " ;
        }

        $db = $this->load->database();
        $result = $this->db->query($sql_data);
        return $result;
    } 

    public function getData($table="") {
        if (!empty($table)) {
            $query = $this->db->get($table);
            return $query->result_array();
        }
        else{
            return null;
        }
    }

    public function getData_col($column, $table="") {
        if (!empty($column) && !empty($table)) {
            $this->db->select($column);
            $query = $this->db->get($table);
            return $query->result_array();
        }
        else{
            return null;
        }
    }

    public function getData_where($table, $where) {
        if (!empty($where) && !empty($table)) {
            $this->db->where($where);
            $query = $this->db->get($table);
            return $query->result_array();
        }
        else{
            return null;
        }
    }

    public function getOne_where($where, $table="") {
        if (!empty($where) && !empty($table)) {
            $this->db->where($where);
            $query = $this->db->get($table);
            return $query->row_array();
        }
        else{
            return null;
        }
    }

    public function getData_by_query($sql=null){
        if(!empty($sql)) {
            $res = $this->db->query($sql)->result_array();
            return $res;
        } else {
            return null;
        }
    }

    public function updateData($table, $data=null, $where=null){
        $this->load->database();
        $msg = 'OK';
        if($data != null && $where != null) {
            $this->db->update($table, $data, $where);
            $err = $this->db->error();
            if($err["message"] !=""){
                $msg = $err["message"];
            }
        }
        return $msg;
    }

    public function insertData($table="", $data=null){
        $this->load->database();
        $msg = false;
        if($data != null) {
            $ins = $this->db->insert($table, $data);
            if(!$ins) {
                $msg = $this->db->error();
            } else {
                $msg = true;
            }
            $this->db->close();
        }
        return $msg;
    }




    // ------------------------------------------------------------------------------------------

    

    public function deletedata($con='',$object=null,$where=null)
    {
        $this->load->database();
        $msg = 'OK';
        $DB2 = $this->load->database($con, TRUE);
        $DB2->table_name = 'mgr.'. $object;
        if($where != null){
            $del = $DB2->delete($DB2->table_name, $where);
            if(!$del) {
                $msg = $DB2->error();
                $msg = $msg["message"];
            } else {
                // $msg = $query;
                $msg = 'OK';
            }
            $DB2->close();
            // if(!$DB2->trans_status()) {
            //     $msg = $DB2->_error_message();
            // }
        }
        return $msg;
    }  

    public function updateData1($con='',$object="", $data=null, $where=null)
    {
        $this->load->database();
        $msg = 'OK';
        $DB2 = $this->load->database($con, TRUE);
        $DB2->table_name = 'mgr.'. $object;
        if($data != null && $where != null) {
            $DB2->update($DB2->table_name, $data, $where);
            // var_dump($DB2);
            // if(!$DB2->trans_status()) {
            // if(!$DB2) {
            //     $msg = $DB2->_error_message();
                $err = $DB2->error();
                if($err["message"] !=""){
                    $msg = $err["message"];
                }
                // var_dump($msg);
            // }
        }
        return $msg;
    }

	
   
	public function getData_by_criteria($con='',$object="", $where=null, $like=null, $order = null)
	{
        $this->load->database();
        $msg = 'OK';
		$DB2 = $this->load->database($con, TRUE);
		$DB2->table_name = 'mgr.'. $object.' with(nolock)';
		if(!is_null($where)) {
			$DB2->where($where);
		} 
        if(!is_null($like)) {
			$DB2->like($like);
		}

		if(!is_null($order)) {
			$DB2->order_by($order[0], $order[1]);
		}
		$query = $DB2->get($DB2->table_name);
        // if(!$DB2->trans_status()) {
        //     $msg = $DB2->_error_message();
        // } else {
        //     $msg = $query->result();
        // }
        // var_dump($con);
        if ($query) {
            $msg = $query->result();
        }
        else {
            $msg = "false";
        }

        $DB2->close();
        return $msg;
    }

    
    
    public function setData_by_query($con='',$sql=null)
    {
        $this->load->database();
        if(!empty($sql)) {
            $DB2 = $this->load->database($con, TRUE);
            $query = $DB2->query($sql);
            // var_dump($query);
            // var_dump($DB2->trans_status());
            // if(!$DB2->trans_status()) {
            if(!$query) {
                $msg = $DB2->error();
                $msg = $msg["message"];
            } else {
                // $msg = $query;
                $msg = 'OK';
            }
            $DB2->close();
            return $msg;
        }
    }

    public function getCount_by_criteria($con='',$object="",$where=null, $like=null)
    {
        $this->load->database();
    	$DB2 = $this->load->database($con, TRUE);
    	// $DB2->table_name = $DB2->username .'.'. $object;
        $DB2->table_name = 'mgr.'. $object.' with(nolock)';
    	if(!is_null($where)) {
    		$DB2->where($where);
    	} else if(!is_null($like)) {
    		$DB2->like($like);
    	}
    	$DB2->from($DB2->table_name);
    	return $DB2->count_all_results();
    }

    public function getCombo($con='',$table='',$object=null, $where=null, $selected_id = '',$order_by=null)
    {
        $this->load->database();
        if(!empty($object))
        {
            $DB2 = $this->load->database($con, TRUE);
            $DB2->table_name = 'mgr.'. $table.' with(nolock)';
            if(!empty($where)){
                $DB2->where($where);
            } 
            if(!empty($order_by)){
                $DB2->order_by($order_by[0], $order_by[1]);
            }  

            $query = $DB2->get($DB2->table_name);
            $rst = $query->result();
            $combo[] = '<option value=""></option>';
            foreach ($rst as $result) {
                if(trim($result->$object[0]) == $selected_id) {
                    $selected = ' selected="1"';
                } else {
                    $selected = '';
                }
                $combo[] = '<option value="'.trim($result->$object[0]).'" '.$selected.'>'.$result->$object[1].'</option>';
            }
            return implode("", $combo);    
        } else {
            return false;
        }
    }

    public function getListAssign($cons, $table='', $sortname='', $sorttype=''){
        $this->load->database();
        $query = " WITH cteMenu(MenuID, Title, URL, ParentMenuID, IconClass, OrderSeq, [Level], Path) AS ( ";
        $query.= " SELECT MenuID, Title, URL, ParentMenuID, IconClass, OrderSeq, 0 as [Level], CAST(ROW_NUMBER() OVER(PARTITION BY ParentMenuID ORDER BY OrderSeq) AS varchar(max)) ";
        $query.= " FROM mgr.".$table." with(nolock) " ;
        $query.= " WHERE ParentMenuID = 0 ";
        $query.= " UNION ALL ";
        $query.= " SELECT mn.MenuID, mn.Title, mn.URL, mn.ParentMenuID, mn.IconClass, mn.OrderSeq, [Level] + 1 as [Level], ";
        $query.= " CONVERT(varchar(max), cteMenu.Path + '.' + CAST(ROW_NUMBER() OVER(PARTITION BY mn.ParentMenuID ORDER BY mn.OrderSeq) AS VARCHAR)) ";
        $query.= " FROM mgr.".$table." mn with(nolock) INNER JOIN cteMenu ON (mn.ParentMenuID = cteMenu.MenuID) ";
        $query.= " ), result_set AS (SELECT ";
        $query.= " ROW_NUMBER() OVER (ORDER BY $sortname $sorttype) AS [row_number], ";
        $query.= " MenuID, Title, URL, ParentMenuID, [Level] as MenuLevel, IconClass, OrderSeq, [Path] ";
        $query.= " FROM cteMenu with(nolock) ";
        $query.= " ) SELECT ";
        $query.= " [row_number], MenuID, Title, Url, ParentMenuID, MenuLevel, IconClass, OrderSeq, [Path] ";
        $query.= " FROM result_set "; 

        $DB2 = $this->load->database($cons, TRUE);
        // $result = $DB2->query($query)->result();
        $result = $DB2->query($query)->result();
        return $result;
    }

    public function getListAssign2($cons, $table='', $sortname='', $sorttype=''){
        $this->load->database();
        $query = " WITH cteMenu(MenuID, Title, URL, ParentMenuID, IconClass, OrderSeq, [Level], Path) AS ( ";
        $query.= " SELECT MenuID, Title, URL, ParentMenuID, IconClass, OrderSeq, 0 as [Level], CAST(ROW_NUMBER() OVER(PARTITION BY ParentMenuID ORDER BY OrderSeq) AS varchar(max)) ";
        $query.= " FROM mgr.".$table." with(nolock) " ;
        $query.= " WHERE ParentMenuID = 0 ";
        $query.= " UNION ALL ";
        $query.= " SELECT mn.MenuID, mn.Title, mn.URL, mn.ParentMenuID, mn.IconClass, mn.OrderSeq, [Level] + 1 as [Level], ";
        $query.= " CONVERT(varchar(max), cteMenu.Path + '.' + CAST(ROW_NUMBER() OVER(PARTITION BY mn.ParentMenuID ORDER BY mn.OrderSeq) AS VARCHAR)) ";
        $query.= " FROM mgr.".$table." mn with(nolock) INNER JOIN cteMenu ON (mn.ParentMenuID = cteMenu.MenuID) ";
        $query.= " ), result_set AS (SELECT ";
        $query.= " ROW_NUMBER() OVER (ORDER BY $sortname $sorttype) AS [row_number], ";
        $query.= " MenuID, Title, URL, ParentMenuID, [Level] as MenuLevel, IconClass, OrderSeq, [Path] ";
        $query.= " FROM cteMenu with(nolock) ";
        $query.= " ) SELECT ";
        $query.= " CAST([row_number] AS INTEGER) as nomor, MenuID, Case ";
        $query.= " When MenuLevel = 0 Then Title ";
        $query.= " When MenuLevel = 1 Then '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' + Title ";
        $query.= " When MenuLevel = 2 Then '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' + Title ";
        $query.= " When MenuLevel = 3 Then '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' + Title ";
        $query.= " Else Title ";
        $query.= " End Title, Url, ParentMenuID, MenuLevel, IconClass, OrderSeq, [Path] ";
        $query.= " FROM result_set ORDER BY [Path] ASC"; 

        $DB2 = $this->load->database($cons, TRUE);
        // $result = $DB2->query($query)->result();
        $result = $DB2->query($query)->result();
        return $result;
    }

    public function getListTable($cons='', $column='', $sortname='', $sorttype='', $table='', $where='', $select=''){
        $result = null;
        $this->load->database();
        $query = " WITH result_set AS ( ";
        $query.= " SELECT ROW_NUMBER() OVER (";
        if(empty($sortname)) {
            $result = null;
        } else {
            $query.=" ORDER BY ".$sortname." ".$sorttype.") AS [row_number], ";
            $result = "OK";
        }
        if(empty($column)) {
            $query.=" * ";
        } else {
            $query.=$column;
        }
        $query.= " FROM ";
        if(empty($table)) {
            $result = null;
        } else {
            $query.= "mgr.".$table." with(nolock) ";
            $result = "OK";
            // $query.= $table." with(nolock) ";
        }
        if(!empty($where)) {
            $query.= "where ".$where;
        }
        $query .= " ) SELECT CAST([row_number] as INTEGER) as nomor,* ";
        if(!empty($select)) {
            $query.= ", $select ";
        }
        $query .= " FROM result_set ORDER BY nomor ASC" ;
        if(!empty($result)) {
            $DB2 = $this->load->database($cons, TRUE);
            $result = $DB2->query($query)->result();
        }        
        return $result;
    }
        
    public function getList($con='',$table='', $column='', $start=0, $pagesize=0, $sortname='', $sorttype='', $params='')
    {
        $this->load->database();
        $startRow = ($start + 1);
        $endRow = ($start + $pagesize);
        $query = " WITH result_set AS ( ";
        $query.= " SELECT ROW_NUMBER() OVER (";
        if(empty($sortname)) {
            $result = null;
        } else {
            $query.=" ORDER BY mgr.".$sortname." ".$sorttype.") AS [row_number], ";
        }        
        if(empty($column)) {
            $query.=" * ";
        } else {
            $query.=$column;
        }
        $query.= " FROM ";
        if(empty($table)) {
            $result = null;
        } else {
            // $query.= "mgr.".$table."with(nolock) ";
            $query.= $table." with(nolock) ";
        }
        if(!empty($params)) {
            $query.= $params;
        }
        $query.= " ) SELECT * FROM result_set WHERE [row_number] BETWEEN ? AND ? ";
        if(!empty($result)) {
            $parameters = array($startRow, $endRow);
            $DB2 = $this->load->database($con, TRUE);
            $result = $DB2->query($query, $parameters)->result();
        }        
        return $result;
    }

    public function getlisttableagent($con='',$table='',$start=0,$pagesize=0,$sortname='',$sortorder='',$param='',$addsort=''){
        $this->load->database();
        $result='';

        $startRow = (int)($start+1);
        $endRow   = (int)($start+$pagesize);
        $sql_data ="WITH result_set AS ( ";
        $sql_data.=" SELECT ";
        $sql_data.=" ROW_NUMBER() OVER (ORDER BY  ".$addsort.",  CAST(".$sortname." AS NVARCHAR(255)) ".$sortorder.") AS [row_number], ";        
        $sql_data.=" * FROM ".$table." with(nolock) ";
        $sql_data.=" ".$param." " ;
        $sql_data.=")";           
        $sql_data.=" SELECT * FROM result_set ";
        // $sql_data.= ($pagesize>0) ? "Where [row_number] BETWEEN ".$startRow." AND ".$endRow : "";
        // var_dump($sql_data); exit;
        $DB2 = $this->load->database($con, TRUE);
        $result = $DB2->query($sql_data);
        return $result;
    }

    public function getlisttable_int_cons($cons="",$table='',$start=0,$pagesize=0,$sortname='',$sortorder='',$param=''){
        $this->load->database();
        $result='';

        $startRow = (int)($start+1);
        $endRow   = (int)($start+$pagesize);
        $sql_data ="WITH result_set AS ( ";
        $sql_data.=" SELECT ";
        $sql_data.=" ROW_NUMBER() OVER (ORDER BY CAST(".$sortname." AS integer) ".$sortorder.") AS [row_number], ";        
        $sql_data.=" * FROM ".$table." with(nolock) ";
        $sql_data.=" ".$param." " ;
        $sql_data.=")";           
        $sql_data.=" SELECT * FROM result_set ";
        $sql_data.= ($pagesize>0) ? "Where [row_number] BETWEEN ".$startRow." AND ".$endRow : "";

        $DB2 = $this->load->database($cons, TRUE);
        $result = $DB2->query($sql_data);
        return $result;
    }   
    
}