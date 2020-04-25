<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Core_Controller {

	public function __construct(){
		parent::__construct();
		$this->_Authorization();
	}

	public function index(){
		$data['title'] = 'Dashboard';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}


	// ROLE --------------------------------------------------------------------------------------------
		public function role(){
			$this->form_validation->set_rules('role', 'Role name', 'required|trim|min_length[3]');

			$data['title'] = 'Access Role';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$data['role'] = $this->db->get('ecrm_user_role')->result_array();
			
			if ($this->form_validation->run() == false) {
				$this->load->view('templates/header', $data);
				$this->load->view('admin/role', $data);
				$this->load->view('templates/footer');
			}
			else{
				$role_name = $this->input->post('role');
				$role = $this->db->insert('ecrm_user_role', ['role' => $role_name]);
				if ($role) {
					$this->session->set_flashdata('message', '
						<div class="alert alert-success" role="alert">
		  					Role created.
						</div>'
					);
					redirect('Admin/role');
				}
				else{
					$this->session->set_flashdata('message', '
						<div class="alert alert-success" role="alert">
		  					Cannot create role.
						</div>'
					);
					redirect('Admin/role');
				}
			}
		}

		public function role_access($role_id){

			$data['title'] = 'Role Managenment - Access';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$data['role'] = $this->db->get_where('ecrm_user_role',[
				'id_role' => $role_id
			])->row_array();
			$data['menu'] = $this->db->get('ecrm_menu')->result_array();


			$this->load->view('templates/header', $data);
			$this->load->view('admin/role_access', $data);
			$this->load->view('templates/footer');
		}

		public function change_access(){
			$id_menu = $this->input->post('menu_id');
			$id_role = $this->input->post('role_id');

			$data = [
				'id_menu' => $id_menu,
				'id_role' => $id_role
			];

			$res = $this->db->get_where('ecrm_menu_access', $data);

			if ($res->num_rows() < 1) {
				$this->db->insert('ecrm_menu_access', $data);
			}
			else{
				$this->db->delete('ecrm_menu_access', $data);
			}

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
						Access changed
				</div>'
			);
		}

		public function role_delete($role_id){
			$del = $this->db->delete('ecrm_user_role', ['id_role' => $role_id]);

			if ($del) {
				$this->session->set_flashdata('message', '
					<div class="alert alert-success" role="alert">
	  					Role deleted.
					</div>'
				);
				redirect('Admin/role');
			}
			else{
				$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
	  					Cannot delete role.
					</div>'
				);
				redirect('Admin/role');
			}
		}
	// END ROLE ----------------------------------------------------------------------------------------

	// USER ROLE ---------------------------------------------------------------------------------------
		public function user_role(){
			$data['title'] = 'Role Managenment';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$data['role'] = $this->db->get('ecrm_user_role')->result_array();
			
			$this->load->view('templates/header', $data);
			$this->load->view('admin/user_role', $data);
			$this->load->view('templates/footer');
		}

		public function getUserRole(){
	        $sSearch = $this->input->post("sSearch",true);
	        if(empty($sSearch)){
	            $sSearch='';
	        }
	        $iDisplayStart = (int)$this->input->get_post('start', true);
	        $iDisplayLength = (int)$this->input->get_post('length', true);
         	$draw = (int)$this->input->get_post('draw', true);

	        $this->load->library('Datatables');
	        $DB2 = $this->load->database();

	        $aColumns  = array('id_user', 'username', 'image', 'status', 'date_created');
	        $sTable = 'ecrm_users';

	        $order = (int)$this->input->get_post('order', true);
	        $Search = $sSearch;
	        $sortIdColumn = (int)$order[0]['column'];
	        $SortdOrder = $order[0]['dir'];
	        $SordField = ($sortIdColumn==0? 'id_user' :$Column[$sortIdColumn]['name']);


	        $filter_search='';
	        if(isset($Search) && !empty($Search)){            
	            for($i=0;$i<count($Column); $i++){
	                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
	                    $filter_search .=  $Column[$i]['name'] ." LIKE '%".$Search."%' OR ";
	                }
	                
	            }
	            $a = strrpos($filter_search, 'OR');        
	            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

	        }
	        $order=" ORDER BY id_role ASC, id_user ASC, status ASC";
	        $param = " ";
	        
	        $rResult = $this->M_model->getDatatable($sTable, $param, $order, $filter_search);

	        $sql="select count(*) as cnt from ".$sTable." ".$param;
	        $ts =  $this->db->query($sql)->result_array();
	        $a = $ts[0]['cnt'];

	        $iTotal = $a;
	        $output = array(
	            'draw' => intval($draw),
	            'recordsTotal' => $iTotal,
	            'recordsFiltered' => $iTotal,
	            'data' => array()
	        );
	        foreach($rResult->result_array() as $aRow)
	        {
	            $row = array(); 
	            
	            foreach($aColumns as $col)
	            {
	                $row[] = $aRow[$col];
	                
	            }
	    
	            $output['data'][] = $aRow;

	        }
	        echo json_encode($output);
		}
	// END USER ROLE -----------------------------------------------------------------------------------


	// // MASTER BARANG IT  -------------------------------------------------------------------------------
	// public function BarangIT(){
	// 		$data['title'] = 'Master Barang IT Support';
			
	// 		$username = $this->session->userdata('username');
	// 		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

	// 		$this->load->view('templates/header', $data);
	// 		$this->load->view('master/barangIT', $data);
	// 		$this->load->view('templates/footer');
	// }

	// public function getBarangIT(){
 //        $sSearch = $this->input->post("sSearch",true);
 //        if(empty($sSearch)){
 //            $sSearch='';
 //        }
 //        $iDisplayStart = (int)$this->input->get_post('start', true);
 //        $iDisplayLength = (int)$this->input->get_post('length', true);
 //     	$draw = (int)$this->input->get_post('draw', true);

 //        $this->load->library('Datatables');
 //        $DB2 = $this->load->database();

 //        $aColumns  = array('idBarang','namaBarang','stok','tanggalInput');
 //        $sTable = 'ecrm_masterbarang';

 //        $order = (int)$this->input->get_post('order', true);
 //        $Search = $sSearch;
 //        $sortIdColumn = (int)$order[0]['column'];
 //        $SortdOrder = $order[0]['dir'];
 //        $SordField = ($sortIdColumn==0? 'idBarang' :$Column[$sortIdColumn]['namaBarang']);


 //        $filter_search='';
 //        if(isset($Search) && !empty($Search)){            
 //            for($i=0;$i<count($Column); $i++){
 //                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
 //                    $filter_search .=  $Column[$i]['name'] ." LIKE '%".$Search."%' OR ";
 //                }
                
 //            }
 //            $a = strrpos($filter_search, 'OR');        
 //            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

 //        }
 //        $order=" ORDER BY idBarang ASC";
 //        $param = " ";
        
 //        $rResult = $this->M_model->getDatatable($sTable, $param, $order, $filter_search);

 //        $sql="select count(*) as cnt from ".$sTable." ".$param;
 //        $ts =  $this->db->query($sql)->result_array();
 //        $a = $ts[0]['cnt'];

 //        $iTotal = $a;
 //        $output = array(
 //            'draw' => intval($draw),
 //            'recordsTotal' => $iTotal,
 //            'recordsFiltered' => $iTotal,
 //            'data' => array()
 //        );
 //        foreach($rResult->result_array() as $aRow)
 //        {
 //            $row = array(); 
            
 //            foreach($aColumns as $col)
 //            {
 //                $row[] = $aRow[$col];
                
 //            }
    
 //            $output['data'][] = $aRow;

 //        }
 //        echo json_encode($output);
	// }

	// public function addBarangIT(){
	// $data['barang'] = $this->db->get('ecrm_masterbarang')->result_array();

	// $this->load->view('master/addBarangIT', $data);
	// }

	// public function deleteBarangIT($id){
	// 		$callback = array(
	//             "Data" => null,
	//             "Error" => false,
	//             "Pesan" => "",
	//             "Status" => 200
	//         );
	// 		$delete = $this->db->delete('ecrm_masterbarang', ['idBarang'=> $id]);
	// 		if ($delete) {
	// 			$callback['Data']	= $delete;
	//         	$callback['Error']	= false;
	//         	$callback['Pesan']	= "Data Deleted";
	//         	$callback['Status'] = 201;
	// 		}
	// 		else{
	// 			$callback['Data']	= $delete;
	//         	$callback['Error']	= true;
	//         	$callback['Pesan']	= "Cannot Delete data";
	//         	$callback['Status'] = 409;
	// 		}

	// 		echo json_encode($callback);
	// }

	// public function getBarangByID($id){
	// $where = array('idBarang' => $id );
	// $data = $this->M_model->getData_where('ecrm_masterbarang', $where);
	// echo json_encode($data);
	// }

	// public function saveBarang($id){
	// 		$callback = array(
	//             "Data" => null,
	//             "Error" => false,
	//             "Pesan" => "",
	//             "Status" => 200
	//         );

	//         if ($_POST) {
	//         	// GET DATA
	//         		$idBarang 		= $this->input->post('idBarang');
	// 	        	$namaBarang		= $this->input->post('namaBarang');
	// 	        	$stok	 		= $this->input->post('stok');
	// 	        	$tanggalInput	= date('y-m-d H:i');

	// 	        // MAKE DATA
	// 		        $idBrg 	= makeID('idBarang', 'ecrm_masterbarang');

	// 		    if($id == "0"){
	// 	    		$data = array(
	// 		        	'idBarang'    => $idBrg,
	// 		        	'namaBarang'  => $namaBarang,
	// 		        	'stok'		  => $stok,
	// 		        	'tanggalInput'=> date('y-m-d H:i');
	// 		        );

	// 		        $insert = $this->db->insert('ecrm_masterbarang', $data);

	// 		        if ($insert) {
	// 		        	$callback['Data']	= $insert;
	// 		        	$callback['Error']	= false;
	// 		        	$callback['Pesan']	= "Barang disimpan dalam database";
	// 		        	$callback['Status'] = 200;
	// 		        }
	// 		        else{
	// 		        	$callback['Data']	= $insert_karyawan;
	// 		        	$callback['Error']	= true;
	// 		        	$callback['Pesan']	= "Tidak bisa menyimpan data";
	// 		        	$callback['Status'] = 406;
	// 		        }
	// 		    }
	// 		    else{
	// 		    	$data = array(
	// 		    		'idBarang' => $idBarang,
	// 		    		'namaBarang'  => $namaBarang,
	// 		        	'stok'		  => $stok,
	// 		        	'tanggalInput'=> date('y-m-d H:i');

	// 		    	);
	// 		    	$where = array('idBarang' => $id );
	// 		    	$update = $this->M_model->updateData('ecrm_masterbarang', $data, $where);

	// 		    	if ($update == 'OK') {
	// 		    		$callback['Data']	= "data berhasil diupdate dengan ID - ".$id;
	// 		        	$callback['Error']	= false;
	// 		        	$callback['Pesan']	= "Data Updated";
	// 		        	$callback['Status'] = 200;
	// 		    	}
	// 		    	else{
	// 		    		$callback['Data']	= $update;
	// 		        	$callback['Error']	= true;
	// 		        	$callback['Pesan']	= "Tidak Bisa edit data";
	// 		        	$callback['Status'] = 406;
	// 		    	}
	// 		    }
	//         }
	//         else{
	//         	$callback['Data']	= $_POST;
	//         	$callback['Error']	= true;
	//         	$callback['Pesan']	= "Tidak ada data";
	//         	$callback['Status'] = 204;
	//         }
	//         echo json_encode($callback);
	// }


}

?>