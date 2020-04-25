<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewUser extends Core_Controller {

	function __construct(){
		parent::__construct();
		$this->_Authorization();
		$this->load->model('M_model');
	}
  	
	public function index(){
		$data['title'] = 'New User';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();


		$this->load->view('templates/header', $data);
		$this->load->view('master/formuser', $data);
		$this->load->view('templates/footer');
	}

	public function user(){
			$data['title'] = 'List Of User';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('master/userNew', $data);
			$this->load->view('templates/footer');
	}

	public function getUser(){
        $sSearch = $this->input->post("sSearch",true);
        if(empty($sSearch)){
            $sSearch='';
        }
        $iDisplayStart = (int)$this->input->get_post('start', true);
        $iDisplayLength = (int)$this->input->get_post('length', true);
     	$draw = (int)$this->input->get_post('draw', true);

        $this->load->library('Datatables');
        $DB2 = $this->load->database();

        $aColumns  = array('id_user','name', 'username', 'id_role', 'id_divisi', 'status','date_created');
        $sTable = 'ecrm_users';

        $order = (int)$this->input->get_post('order', true);
        $Search = $sSearch;
        $sortIdColumn = (int)$order[0]['column'];
        $SortdOrder = $order[0]['dir'];
        $SordField = ($sortIdColumn==0? 'id_user' :$Column[$sortIdColumn]['username']);


        $filter_search='';
        if(isset($Search) && !empty($Search)){            
            for($i=0;$i<count($Column); $i++){
                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
                    $filter_search .=  $Column[$i]['id_user'] ." LIKE '%".$Search."%' OR ";
                }
                
            }
            $a = strrpos($filter_search, 'OR');        
            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

        }
        $order=" ORDER BY id_user ASC";
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


	public function addNewUser(){
			// $data['id_user'] = $this->db->get('ecrm_users')->result_array();
			$data['role'] = $this->db->get('ecrm_user_role')->result_array();
			$data['divisi'] = $this->db->get('ecrm_divisi')->result_array();


			$this->load->view('master/addUser', $data);
	}


	public function deleteUser($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );
			$delete = $this->db->delete('ecrm_users', ['id_user'=> $id]);
			if ($delete) {
				$callback['Data']	= $delete;
	        	$callback['Error']	= false;
	        	$callback['Pesan']	= "Data Deleted";
	        	$callback['Status'] = 201;
			}
			else{
				$callback['Data']	= $delete;
	        	$callback['Error']	= true;
	        	$callback['Pesan']	= "Cannot Delete data";
	        	$callback['Status'] = 409;
			}

			echo json_encode($callback);
	}


	public function getUserByID($id){
		// console.log('test');
		$where = array('id_user' => $id );
		$data = $this->M_model->getData_where('ecrm_users', $where);
		echo json_encode($data);
	}


	public function saveUser($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );

	        if ($_POST) {
	        	// GET DATA
	        		$id_user  		= $this->input->post('id_user');
		        	$name 			= $this->input->post('name');
		        	$username 		= $this->input->post('username');
		 			$password 		= password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		 			$id_role		= $this->input->post('id_role');
		 			$id_divisi 		= $this->input->post('id_divisi');
		 			$status 		= $this->input->post('status');
		 			$date_created 	= date('Y-m-d');	

		        // MAKE DATA
			        // $idBrg 	= makeID_inisial('id_user', 'ecrm_users', 'KM');
			        $pass 	= generateRandomString(5);

			    if($id == "0"){
		    		$data = array(
			        	'id_user'    	=> $id_user,
			        	'name' 			=> $name,
			        	'username' 		=> $username,
			        	'password' 		=> $pass,
			        	'id_role' 		=> $id_role,
			        	'id_divisi' 	=> $id_divisi,
			        	'status' 		=> 1,
			        	'date_created'  => date('Y-m-d')
			        );

			        $insert = $this->db->insert('ecrm_users', $data);

			        if ($insert) {
			        	$callback['Data']	= $insert;
			        	$callback['Error']	= false;
			        	$callback['Pesan']	= "User disimpan dalam database";
			        	$callback['Status'] = 200;
			        }
			        else{
			        	$callback['Data']	= $insert_karyawan;
			        	$callback['Error']	= true;
			        	$callback['Pesan']	= "Tidak bisa menyimpan data";
			        	$callback['Status'] = 406;
			        }
			    }
			    else{
			    	$data = array(
			    		'name'   => $name,
			    		'username' 		=> $username,
			        	'password' 		=> $password,
			        	'id_role' 		=> $id_role,
			        	'id_divisi' 	=> $id_divisi,
			        	'status' 		=> 1,
			        	'date_created'  => date('Y-m-d')

			    	);
			    	$where = array('id_user' => $id );
			    	$update = $this->M_model->updateData('ecrm_users', $data, $where);

			    	if ($update == 'OK') {
			    		$callback['Data']	= "data berhasil diupdate dengan ID - ".$id;
			        	$callback['Error']	= false;
			        	$callback['Pesan']	= "Data Updated";
			        	$callback['Status'] = 200;
			    	}
			    	else{
			    		$callback['Data']	= $update;
			        	$callback['Error']	= true;
			        	$callback['Pesan']	= "Tidak Bisa edit data";
			        	$callback['Status'] = 406;
			    	}
			    }
	        }
	        else{
	        	$callback['Data']	= $_POST;
	        	$callback['Error']	= true;
	        	$callback['Pesan']	= "Tidak ada data";
	        	$callback['Status'] = 204;
	        }
	        echo json_encode($callback);
	}

	// public function submit()
	// {
	// 	$this->load->model('User_model');
	// 	$table = 'ecrm_users';
	// 	$fields = 'id_user';
	// 	$inisial = 'U';

	//  	$iduser = $this->input->post('id_user');
	//  	if ($iduser =='') {
	//  		if (!is_null($this->input->post('status'))) {
	//  			$status = 1;
	//  		}
	//  		else{
	//  			$status = 0;
	//  		}
	//  		$upload_img = $_FILES['image']['name'];

	// 		if ($upload_img) {
	// 			$config['allowed_types'] = 'jpg|png';
	// 			$config['max_size']     = '10240';
	// 			$config['upload_path'] = './assets/img/profile';

	// 			$this->load->library('upload', $config);

	// 			if ($this->upload->do_upload('image')) {
	// 				$new_image = $this->upload->data('file_name');
	// 			}else
	// 			{
	// 				echo $this->upload->display_errors();
	// 			}
	// 		}

	// 	 	$autoid = makeID_inisial($fields, $table, $inisial);
	// 	 	$C_insertuser = array(
	// 	 		'id_user' => $autoid,
	//  			'name' => $this->input->post('name'),
	//  			'username' => $this->input->post('username'),
	//  			'image' => $new_image,
	//  			'password' => 	password_hash($this->input->post('password'), PASSWORD_DEFAULT),
	//  			'id_role' => $this->input->post('id_role'),
	//  			'id_divisi' => $this->input->post('id_divisi'),
	//  			'status' => $status,
	//  			'date_created' => date('Y-m-d')
	//  		);

	//  		$add = $this->User_model->add($C_insertuser);
	//  	}
 // 		else {
	// 	 	$data = array(
	// 			'name' => $this->input->post('name'),
	// 			'username' => $this->input->post('username'),
	// 			'image' => $this->input->post('image'),
	// 			'password' => $this->input->post('password'),
	// 			'id_role' => $this->input->post('id_role'),
	// 			'id_divisi' => $this->input->post('id_divisi'),
	// 			'status' => $this->input->post('status')
	// 		);
	// 		$upload_img = $_FILES['image']['name'];

	// 		if ($upload_img) {
	// 			$config['allowed_types'] = 'jpg|png';
	// 			$config['max_size']     = '10240';
	// 			$config['upload_path'] = './assets/img/profile';

	// 			$this->load->library('upload', $config);

	// 			if ($this->upload->do_upload('image')) {
	// 				$old_image = $data['user']['image'];

	// 				if ($old_image != 'default.jpg') {
	// 					unlink(FCPATH.'assets/img/profile/'.$old_image);
	// 				}

	// 				$new_image = $this->upload->data('file_name');
	// 				$this->db->set('image', $new_image);
	// 			}else
	// 			{
	// 				echo $this->upload->display_errors();
	// 			}
	// 		}

	// 		$this->User_model->update($iduser, $data);
 // 		}
	// }

	// public function show_list_users()
	// {
	// 	$data['title'] = "List User";
	// 	$this->load->model('User_model');
	// 	$data["master"] = $this->User_model->get_newuser();
	// 	$username = $this->session->userdata('username');
	// 	$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
	// 	// $this->load->view('pelanggan/list_pelanggan',$data);
	// 	// 
	// 	$this->load->view('templates/header', $data);
	// 	$this->load->view('master/list_user', $data);
	// 	$this->load->view('templates/footer');
	// }

	// public function hapus_user()
	// {
	// 	$this->load->model('User_model');
	// 	$username = $this->uri->segment(3);
	// 	$this->User_model->delete_newuser($username);
	// }

	// public function edit_user()
	// {
	// 	$namauser = $this->uri->segment(3);
	// 	$data['title'] = 'Update User';
		
	// 	$data['user'] = $this->db->get_where('ecrm_users', ['id_user' => $namauser])->row_array();
	// 	$data['role'] = $this->db->get('ecrm_user_role')->result_array();
	// 	$data['divisi'] = $this->db->get('ecrm_divisi')->result_array();
	// 	$this->load->view('templates/header', $data);
	// 	$this->load->view('master/formuser', $data);
	// 	$this->load->view('templates/footer');
	// 	// $this->load->view('request_it/form',$data);		
	// }

}
