<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Core_Controller {

	public function __construct(){
		parent::__construct();
		$this->_Authorization();
	}

	public function index(){

		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['title'] = 'Profile'; 


		$this->load->view('templates/header', $data);
		$this->load->view('User/index', $data);
		$this->load->view('templates/footer');
	}


	public function edit(){
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['title'] = 'Edit Profile'; 

		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');
		}
		else{
			$name = $this->input->post('name');
			$username = $this->input->post('username');

			//cek gambar
			$upload_img = $_FILES['image']['name'];

			if ($upload_img) {
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']     = '10240';
				$config['upload_path'] = './assets/img/profile';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];

					if ($old_image != 'default.jpg') {
						unlink(FCPATH.'assets/img/profile/'.$old_image);
					}

					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				}else
				{
					echo $this->upload->display_errors();
				}
			}

			$this->db->set('name',$name);
			$this->db->where('username', $username);
			$this->db->update('ecrm_users');

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
  					Profile Updated!
				</div>'
			);
			redirect('User');
		}
	}

	public function change_pass(){
		$username = $this->session->userdata('username');
		$data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();
		$data['title'] = 'Change Password'; 

		$this->form_validation->set_rules('oldpass', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[3]|matches[newpass2]');
		$this->form_validation->set_rules('newpass2', 'Confirm New Password', 'trim|required|matches[newpass]');

		if ($this->form_validation->run() == false) {

			$this->load->view('templates/header', $data);
			$this->load->view('user/change_password', $data);
			$this->load->view('templates/footer');	
		}
		else{
			$oldpass = $this->input->post('oldpass');
			$newpass = $this->input->post('newpass');
			if (!password_verify($oldpass, $data['user']['password'])) {
				$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
	  					worng current password
					</div>'
				);
				redirect('User/change_pass');
			}
			else{
				if ($oldpass == $newpass) {
					$this->session->set_flashdata('message', '
						<div class="alert alert-danger" role="alert">
		  					New password cannot be the same as current password
						</div>'
					);
					redirect('User/change_pass');
				}
				else{
					//password ok
					$pass_hash = password_hash($newpass, PASSWORD_DEFAULT);

					$this->db->set('password', $pass_hash);
					$this->db->where('username', $username);
					$this->db->update('ecrm_users');

					$this->session->set_flashdata('message', '
						<div class="alert alert-success" role="alert">
		  					password change
						</div>'
					);
					redirect('User/change_pass');
				}
			}
		}
	}
}

?>