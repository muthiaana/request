<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriMasalah extends Core_Controller {

	function __construct(){
		parent::__construct();
		$this->_Authorization();
		$this->load->model('M_model');
	}
  	
	public function index(){
		$data['title'] = 'Kategori Masalah';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('master/masalah', $data);
		$this->load->view('templates/footer');
	}



	// MASTER BARANG IT  -------------------------------------------------------------------------------
	public function katmasalah(){
			$data['title'] = 'Kategori Masalah';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('Master/masalah', $data);
			$this->load->view('templates/footer');
	}

	public function getKatMasalah(){
        $sSearch = $this->input->post("sSearch",true);
        if(empty($sSearch)){
            $sSearch='';
        }
        $iDisplayStart = (int)$this->input->get_post('start', true);
        $iDisplayLength = (int)$this->input->get_post('length', true);
     	$draw = (int)$this->input->get_post('draw', true);

        $this->load->library('Datatables');
        $DB2 = $this->load->database();

        $aColumns  = array('id_kat_masalah','kategorimasalah');
        $sTable = 'ecrm_kategori_masalah';

        $order = (int)$this->input->get_post('order', true);
        $Search = $sSearch;
        $sortIdColumn = (int)$order[0]['column'];
        $SortdOrder = $order[0]['dir'];
        $SordField = ($sortIdColumn==0? 'id_kat_masalah' :$Column[$sortIdColumn]['kategorimasalah']);


        $filter_search='';
        if(isset($Search) && !empty($Search)){            
            for($i=0;$i<count($Column); $i++){
                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
                    $filter_search .=  $Column[$i]['id_kat_masalah'] ." LIKE '%".$Search."%' OR ";
                }
                
            }
            $a = strrpos($filter_search, 'OR');        
            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

        }
        $order=" ORDER BY id_kat_masalah ASC";
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


	public function addMasalahKat(){
			$data['id_kat_masalah'] = $this->db->get('ecrm_kategori_masalah')->result_array();

			$this->load->view('master/addMasalah', $data);
	}


	public function deleteMasalah($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );
			$delete = $this->db->delete('ecrm_kategori_masalah', ['id_kat_masalah'=> $id]);
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


	public function getMasalahByID($id){
		// console.log('test');
		$where = array('id_kat_masalah' => $id );
		$data = $this->M_model->getData_where('ecrm_kategori_masalah', $where);
		echo json_encode($data);
	}


	public function saveMasalah($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );

	        if ($_POST) {
	        	// GET DATA
	        		$id_kat_masalah  = $this->input->post('id_kat_masalah');
		        	$kategorimasalah = $this->input->post('kategorimasalah');

		        // MAKE DATA
			        $idBrg 	= makeID_inisial('id_kat_masalah', 'ecrm_kategori_masalah', 'KM');

			    if($id == "0"){
		    		$data = array(
			        	'id_kat_masalah'    => $idBrg,
			        	'kategorimasalah'  => $kategorimasalah
			        );

			        $insert = $this->db->insert('ecrm_kategori_masalah', $data);

			        if ($insert) {
			        	$callback['Data']	= $insert;
			        	$callback['Error']	= false;
			        	$callback['Pesan']	= "Barang disimpan dalam database";
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
			    		'kategorimasalah'   => $kategorimasalah

			    	);
			    	$where = array('id_kat_masalah' => $id );
			    	$update = $this->M_model->updateData('ecrm_kategori_masalah', $data, $where);

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
	// 	$this->load->model('KategoriMasalah_Model');
	// 	$table = 'ecrm_kategori_masalah';
	// 	$fields = 'id_kat_masalah';
	// 	$inisial = 'KM';

	//  	$idkatmasalah = $this->input->post('id_kat_masalah');
	 	
	// 		 	if ($idkatmasalah =='') {
	// 		 		$idkatmasalahh = makeID_inisial($fields, $table, $inisial);
	// 		 		$C_KategoriMasalah = array(
	// 		 			'id_kat_masalah' => $idkatmasalahh,
	// 		 			'kategorimasalah' => $this->input->post('kategorimasalah')
	// 		 		);
	// 		 		$this->KategoriMasalah_Model->add($C_KategoriMasalah);
	// 		 	}else {
	// 		 		$data = array(
	// 		 			'kategorimasalah' => $this->input->post('kategorimasalah')
	// 		 		);	
	// 		 		$this->KategoriMasalah_Model->update($idkatmasalah, $data);
	// 		 	}

	// }
	// public function show_list_masalah()
	// {
	// 	$data['title'] = "Kategori Masalah";
	// 	$this->load->model('KategoriMasalah_Model');
	// 	$data['master'] = $this->KategoriMasalah_Model->get_masalah();
	// 	$username = $this->session->userdata('username');
	// 	$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
	// 	// $this->load->view('pelanggan/list_pelanggan',$data);
	// 	// 
	// 	$this->load->view('templates/header', $data);
	// 	$this->load->view('master/list_katmasalah', $data);
	// 	$this->load->view('templates/footer');
	// }

	// public function hapus_masalah()
	// {
	// 	$this->load->model('KategoriMasalah_Model');
	// 	$idkat = $this->uri->segment(3);
	// 	$this->KategoriMasalah_Model->delete_masalah($idkat);

	// }

	// public function edit_masalah()
	// // {
	// // 	$idkatmasalah = $this->uri->segment(3);
	// // 	$this->load->model('KategoriMasalah_Model');
	// // 	$data["data_masalah"] = $this->KategoriMasalah_Model->get_user_detail($username);
	// // 	$data['title'] = "Update Kategori Masalah";
	// // 	$this->load->view('master/forkatmasalah',$data);
	// // }

	// {
	// 	$this->load->model('KategoriMasalah_Model');
	// 	$idkatmasalah = $this->uri->segment(3);
	// 	$data['title'] = 'Update Kategori Masalah';
	// 	$data["data_masalah"] = $this->KategoriMasalah_Model->get_masalah_detail($idkatmasalah);
	// 	$username = $this->session->userdata('username');
	// 	$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

	// 	$this->load->view('templates/header', $data);
	// 	$this->load->view('master/formkatmasalah', $data);
	// 	$this->load->view('templates/footer');
	// 	// $this->load->view('request_it/form',$data);		
	// }



}
