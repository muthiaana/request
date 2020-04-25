<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Core_controller {

	public function __construct(){
        parent::__construct();
        $this->_Authorization();
		$this->load->model('M_model');
    }

	// MASTER Laporan BARANG IT  -------------------------------------------------------------------------------
	public function barangLaporan() {
			$data['title'] = 'Laporan Barang IT Support';
			
			$username = $this->session->userdata('username');
			$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('laporan/reportbarang', $data);
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


	public function getBarangByID($id) {
		$where = array('idBarang' => $id );
		$data = $this->M_model->getData_where('ecrm_masterbarang', $where);
		echo json_encode($data);
	}


	public function getLaporan_ListBarang() {
		$awal = $this->input->post('tgl_awal');
		$akhir = $this->input->post('tgl_akhir');
		$sql = "
					SELECT idBarang, namaBarang, 
					COUNT(if (tipeTransaksi) = 1, jumlah, null) as Pengeluaran, 
					COUNT(if(tipeTransaksi) = 2, jumlah, null) as Pemasukan, 
					sum (Pemasukan-Pengeluaran) 
					FROM `ecrm_masterbarang`
					where tanggalInput BETWEEN '".$awal."' AND '".$akhir."')
				";
            // var_dump($sql);die;
		$data = $this->M_model->getData_by_query($sql);
		echo json_encode($data);
	}


  // function getlist(){
  //   $pelangganId = $this->input->post('namaPelanggan');
  //   $dateStart = $this->input->post('dateStart');
  //   $dateEnd = $this->input->post('dateEnd');
  //   $filter=array();

  //   if($pelangganId !='0')
  //       $filter['h.idPelanggan'] = $pelangganId;

  //   $filter['h.tglPesan >= "'.$dateStart.
  //         '" AND h.tglPesan <="'.$dateEnd.'"'] = Null;

  //   $data['pesanan'] = $this->Pesanan_model->get($filter);

  //   $this->load->view('pesanan/daftar_pesanan_table',$data);
  // }

}

/* End of file Report.php */
/* Location: ./application/controllers/Report.php */



// // SELECT idBarang, namaBarang,
// 						SUM(if(tipeTransaksi="1", jumlah, null)) as Pengeluaran, 							
// 						SUM(if(tipeTransaksi="2", jumlah, null)) as Pn, 
// 						SUM(Pn - Pengeluaran) 
// 						FROM ecrm_masterbarang
// 						where tanggalInput BETWEEN '2020-04-01' AND '2020-04-19'