<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends Core_Controller {

	function __construct(){
		parent::__construct();
		$this->_Authorization();
		$this->load->model('M_model');
	}


	public function index(){
		$data['title'] = 'Master Barang IT';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('Master/barangIT', $data);
		$this->load->view('templates/footer');
	}

	// Mater Barang BARANG IT  -------------------------------------------------------------------------------

	public function masterbarangIT(){
			$data['title'] = 'Master Barang IT Support';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('master/MasterBarang', $data);
			$this->load->view('templates/footer');
	}

	public function getmasterBarangIT(){
        $sSearch = $this->input->post("sSearch",true);
        if(empty($sSearch)){
            $sSearch='';
        }
        $iDisplayStart = (int)$this->input->get_post('start', true);
        $iDisplayLength = (int)$this->input->get_post('length', true);
     	$draw = (int)$this->input->get_post('draw', true);

        $this->load->library('Datatables');
        $DB2 = $this->load->database();

        $aColumns  = array('idBarang','namaBarang');
        $sTable = 'ecrm_barang';

        $order = (int)$this->input->get_post('order', true);
        $Search = $sSearch;
        $sortIdColumn = (int)$order[0]['column'];
        $SortdOrder = $order[0]['dir'];
        $SordField = ($sortIdColumn==0? 'idBarang' :$Column[$sortIdColumn]['namaBarang']);


        $filter_search='';
        if(isset($Search) && !empty($Search)){            
            for($i=0;$i<count($Column); $i++){
                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
                    $filter_search .=  $Column[$i]['idBarang'] ." LIKE '%".$Search."%' OR ";
                }
                
            }
            $a = strrpos($filter_search, 'OR');        
            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

        }
        $order=" ORDER BY idBarang ASC";
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


	public function addMasterBarang(){
			$data['idbarang'] = $this->db->get('ecrm_barang')->result_array();

			$this->load->view('master/addMasterBarang', $data);
	}


	public function deleteMasterBarangIT($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );
			$delete = $this->db->delete('ecrm_barang', ['idBarang'=> $id]);
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


	public function getMasterBarangByID($id) {
		$where = array('idBarang' => $id );
		$data = $this->M_model->getData_where('ecrm_barang', $where);
		echo json_encode($data);
	}


	public function saveMasterBarang($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );

	        if ($_POST) {
	        	// GET DATA
	        		$idBarang 		= $this->input->post('idBarang');
		        	$namaBarang		= $this->input->post('namaBarang');

		        // MAKE DATA
			        $idBrg 	= makeID_inisial('idBarang', 'ecrm_barang', 'BR');

			    if($id == "0"){
		    		$data = array(
			        	'idBarang'   	 => $idBrg,
			        	'namaBarang' 	 => $namaBarang
			        );
			        // echo "$insert";
			        $insert = $this->db->insert('ecrm_barang', $data);

			        if ($insert) {
			        	$callback['Data']	= $insert;
			        	$callback['Error']	= false;
			        	$callback['Pesan']	= "Barang disimpan dalam database";
			        	$callback['Status'] = 200;
			        }
			        else{
			        	$callback['Data']	= $insert_karyawan; //$insert_karyawan
			        	$callback['Error']	= true;
			        	$callback['Pesan']	= "Tidak bisa menyimpan data";
			        	$callback['Status'] = 406;
			        }
			    }
			    else{
			    	$data = array(
			    		'namaBarang' 	  => $namaBarang

			    	);
			    	$where = array('idBarang' => $id );
			    	$update = $this->M_model->updateData('ecrm_barang', $data, $where);

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



// MASTER Laporan BARANG IT  -------------------------------------------------------------------------------
	public function barangLaporan() {
			$data['title'] = 'Laporan Barang IT Support';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('Master/barangLaporan', $data);
			$this->load->view('templates/footer');
	}

	public function getLaporanBarangIT(){
        $sSearch = $this->input->post("sSearch",true);
        if(empty($sSearch)){
            $sSearch='';
        }
        $iDisplayStart = (int)$this->input->get_post('start', true);
        $iDisplayLength = (int)$this->input->get_post('length', true);
     	$draw = (int)$this->input->get_post('draw', true);

        $this->load->library('Datatables');
        $DB2 = $this->load->database();

        $aColumns  = array('idBarang','namaBarang');
        $sTable = 'ecrm_masterbarang';

        $order = (int)$this->input->get_post('order', true);
        $Search = $sSearch;
        $sortIdColumn = (int)$order[0]['column'];
        $SortdOrder = $order[0]['dir'];
        $SordField = ($sortIdColumn==0? 'idBarang' :$Column[$sortIdColumn]['namaBarang']);


        $filter_search='';
        if(isset($Search) && !empty($Search)){            
            for($i=0;$i<count($Column); $i++){
                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
                    $filter_search .=  $Column[$i]['idBarang'] ." LIKE '%".$Search."%' OR ";
                }
                
            }
            $a = strrpos($filter_search, 'OR');        
            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

        }
        $order=" ORDER BY idBarang ASC";
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




// Stok BARANG IT  -------------------------------------------------------------------------------
	public function barangIT(){
			$data['title'] = 'Master Barang IT Support';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('Master/barangIT', $data);
			$this->load->view('templates/footer');
	}

	public function getBarangIT(){
        $sSearch = $this->input->post("sSearch",true);
        if(empty($sSearch)){
            $sSearch='';
        }
        $iDisplayStart = (int)$this->input->get_post('start', true);
        $iDisplayLength = (int)$this->input->get_post('length', true);
     	$draw = (int)$this->input->get_post('draw', true);

        $this->load->library('Datatables');
        $DB2 = $this->load->database();

        $aColumns  = array('NoStok','idBarang','jumlah','tanggalInput', 'tipeTransaksi', 'Keterangan');
        $sTable = 'ecrm_masterbarang';

        $order = (int)$this->input->get_post('order', true);
        $Search = $sSearch;
        $sortIdColumn = (int)$order[0]['column'];
        $SortdOrder = $order[0]['dir'];
        $SordField = ($sortIdColumn==0? 'NoStok' :$Column[$sortIdColumn]['idBarang']);


        $filter_search='';
        if(isset($Search) && !empty($Search)){            
            for($i=0;$i<count($Column); $i++){
                if(isset($Column[$i]['searchable']) && $Column[$i]['searchable']=='true'){
                    $filter_search .=  $Column[$i]['idBarang'] ." LIKE '%".$Search."%' OR ";
                }
                
            }
            $a = strrpos($filter_search, 'OR');        
            $filter_search = (!empty($filter_search)? "AND (".substr($filter_search, 0,$a).")":$filter_search);     

        }
        $order=" ORDER BY NoStok ASC";
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


	public function addBarang(){
			$data['idbarang'] = $this->db->get('ecrm_masterbarang')->result_array();
			$data['barang'] = $this->db->get('ecrm_barang')->result_array();

			$this->load->view('master/addBarangIT', $data);
	}


	public function deleteBarangIT($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );
			$delete = $this->db->delete('ecrm_masterbarang', ['NoStok'=> $id]);
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


	public function getBarangByID($id) {
		$where = array('NoStok' => $id );
		$data = $this->M_model->getData_where('ecrm_masterbarang', $where);
		echo json_encode($data);
	}

	public function getSumByID($id){
		$data = array('jumlah' => $stok_lama + $stok_tambah);

		$criteria = array('NoStok' => $id);
		$data = $this->M_model->updateDataSUM('ecrm_masterbarang',$data, $criteria);
		echo json_encode($data);
	}


	public function saveBarang($id){
			$callback = array(
	            "Data" => null,
	            "Error" => false,
	            "Pesan" => "",
	            "Status" => 200
	        );

	        if ($_POST) {
	        	// GET DATA
	        		$NoStok 		= $this->input->post('NoStok');
	        		$idBarang 		= $this->input->post('idBarang');
		        	// $namaBarang		= $this->input->post('namaBarang');
		        	$jumlah	 		= $this->input->post('jumlah');
		        	$tanggalInput	= date('y-m-d H:i');
		        	$tipeTransaksi	= $this->input->post('tipeTransaksi');
		        	$Keterangan	    = $this->input->post('Keterangan');


		        // MAKE DATA
			        $NoStokBrg 	= makeID_inisial('NoStok', 'ecrm_masterbarang', 'S');

			    if($id == "0"){
		    		$data = array(
		    			'NoStok'		 => $NoStokBrg,
			        	'idBarang'   	 => $idBarang,
			        	// 'namaBarang' 	 => $namaBarang,
			        	'jumlah'		 => $jumlah,
			        	'tanggalInput'	 => date('y-m-d H:i'),
			        	'tipeTransaksi'  => $tipeTransaksi,
			        	'Keterangan'     => $Keterangan
			        );
			        $insert = $this->db->insert('ecrm_masterbarang', $data);

			        if ($insert) {
			        	$callback['Data']	= $insert;
			        	$callback['Error']	= false;
			        	$callback['Pesan']	= "Barang disimpan dalam database";
			        	$callback['Status'] = 200;
			        }
			        else{
			        	$callback['Data']	= $insert_karyawan; //$insert_karyawan
			        	$callback['Error']	= true;
			        	$callback['Pesan']	= "Tidak bisa menyimpan data";
			        	$callback['Status'] = 406;
			        }
			    }
			    else{
			    	$data = array(
			    		'idBarang' 	  	  => $idBarang,
			    		// 'namaBarang' 	  => $namaBarang,
			        	'jumlah'		  => $jumlah,
			        	'tanggalInput'	  => date('y-m-d H:i'),
			        	'tipeTransaksi'   => $tipeTransaksi,
			        	'Keterangan'      => $Keterangan

			    	);
			    	$where = array('NoStok' => $id );
			    	$update = $this->M_model->updateData('ecrm_masterbarang', $data, $where);

			    	if ($update == 'OK') {
			    		$callback['Data']	= "data berhasil diupdate dengan No Stok - ".$id;
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


}