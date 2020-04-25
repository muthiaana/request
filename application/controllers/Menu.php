<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Core_Controller {

	function __construct(){
		parent::__construct();
		$this->_Authorization();
		$this->load->model('M_model');
	}

	public function index(){
		
		$data['title'] = 'Menu Management';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$data['menu'] = $this->M_model->getData('ecrm_menu');

		$this->form_validation->set_rules('menu', 'Menu Name', 'required');

		if ($this->form_validation->run() == false) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/footer');
			
		}
		else{
			$menuName = ucwords($this->input->post('menu'));
			$icon = $this->input->post('icon');

			$this->db->insert('ecrm_menu', [
				'menu' => $menuName,
				'icon' => $icon
			]);

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					New menu added.
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                	</button>
				</div>'
			);
			redirect('Menu');
		}
	}

	public function menu_delete($id){
		$del = $this->db->delete('ecrm_menu', ['id_menu' => $id]);

		if ($del) {
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					Menu deleted.
				</div>'
			);
			redirect('Menu');
		}
		else{
			$this->session->set_flashdata('message', '
				<div class="alert alert-danger" role="alert">
  					Cannot delete menu.
				</div>'
			);
			redirect('Menu');
		}
	}

	public function menu_edit($id){
		$data['title'] = 'Menu Managenment - Edit';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$data['menu'] = $this->db->get_where( 'ecrm_menu',['id_menu' => $id] )->row_array();

		$this->form_validation->set_rules('menu', 'Menu name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('icon', 'icon', 'trim|required|min_length[3]');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('menu/menu_edit', $data);
			$this->load->view('templates/footer');
		}
		else{
			$menu = $this->input->post('menu');
			$icon = $this->input->post('icon');

			$this->db->set('menu', $menu);
			$this->db->set('icon', $icon);
			$this->db->where('id_menu', $id);
			$this->db->update('ecrm_menu');
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					Menu edited
				</div>'
			);
			redirect('Menu');
		}
	}



	public function subMenu(){
		
		$data['title'] = 'Submenu Management';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$query = "	
			SELECT `ecrm_menu_sub`.*, `ecrm_menu`.`menu` 
			FROM `ecrm_menu_sub` 
			JOIN `ecrm_menu`
			ON `ecrm_menu_sub`.`id_menu` = `ecrm_menu`.`id_menu`
		";

		$data['subMenu'] = $this->M_model->getData_by_query($query);
		$data['menu'] = $this->M_model->getData('ecrm_menu');

		$this->form_validation->set_rules('title', 'Menu Title', 'required');
		$this->form_validation->set_rules('id_menu', 'Menu Name', 'required');
		$this->form_validation->set_rules('url', 'URL', 'required');
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('menu/subMenu', $data);
			$this->load->view('templates/footer');
			
		}
		else{
			$status = $this->input->post('is_active');
			if (!isset($status)) {
				$status = 0;
			}
			$data = [
				'title' => ucwords($this->input->post('title')),
				'id_menu' => $this->input->post('id_menu'),
				'url' => $this->input->post('url'),
				'status' => $status
			];

			$this->db->insert('ecrm_menu_sub', $data);

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					New submenu added.
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                	</button>
				</div>'
			);
			redirect('Menu/subMenu');
		}
	}

	public function submenu_delete($id){
		$del = $this->db->delete('ecrm_menu_sub', ['id_sub' => $id]);

		if ($del) {
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					subMenu deleted.
				</div>'
			);
			redirect('Menu/subMenu');
		}
		else{
			$this->session->set_flashdata('message', '
				<div class="alert alert-danger" role="alert">
  					Cannot delete submenu.
				</div>'
			);
			redirect('Menu/subMenu');
		}
	}

	public function submenu_edit($id){
		$data['title'] = 'Menu Managenment - Edit';
		
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

		$query = "	
			SELECT `ecrm_menu_sub`.*, `ecrm_menu`.`menu` 
			FROM `ecrm_menu_sub` 
			JOIN `ecrm_menu`
			ON `ecrm_menu_sub`.`id_menu` = `ecrm_menu`.`id_menu`
		";

		$data['subMenu'] = $this->M_model->getData_by_query($query);

		$data['menu'] = $this->M_model->getData('ecrm_menu');
		$data['menuid'] = $this->db->get_where( 'ecrm_menu_sub',['id_sub' => $id] )->row_array();

		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('id_menu', 'Parent menu', 'trim|required');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('menu/submenu_edit', $data);
			$this->load->view('templates/footer');
		}
		else{
			$title = $this->input->post('title');
			$id_menu = $this->input->post('id_menu');
			$url = $this->input->post('url');
			$status = $this->input->post('is_active');
			if (!isset($status)) {
				$status = 0;
			}
			$this->db->set('title', $title);
			$this->db->set('id_menu', $id_menu);
			$this->db->set('url', $url);
			$this->db->set('status', $status);
			$this->db->where('id_sub', $id);
			$this->db->update('ecrm_menu_sub');
			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					Menu edited
				</div>'
			);
			redirect('Menu/submenu');
		}
	}

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */