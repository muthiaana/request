<?php
if (! defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Core_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        date_default_timezone_set("Asia/Jakarta");    
        $this->load->model('M_model');
    }

    public function _Authorization(){
        
        if (!$this->session->userdata('username')) {
            redirect('Auth','refresh');
        }
        else{
            $id_role    = $this->session->userdata('id_role');
            $menu       = $this->uri->segment(1);

            $querymenu = $this->db->get_where('ecrm_menu',['menu' => $menu])->row_array();
            $id_menu   = $querymenu['id_menu'];

            $queryaccess =  $this->db->get_where('ecrm_menu_access',[
                'id_role' => $id_role,
                'id_menu' => $id_menu
            ]);

            if ($queryaccess->num_rows() < 1) {
                redirect('Auth/blocked');
            }
        }
       
    }

    public function _Redirect(){
        $id_role    = $this->session->userdata('id_role');
        switch ($id_role) {
            case 1:
                redirect('Admin','refresh');
                break;
            case 2:
                redirect('User','refresh');
                break;
            default:
                redirect('Auth','refresh');
                break;
        }
    }
}