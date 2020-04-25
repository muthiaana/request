<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Core_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$username = $this->session->userdata('username');
		if (!empty( $username ) ) {
			$this->_Redirect();
		}else{

			//Form Validation Rules
				$this->form_validation->set_rules('username', 'Username', 'required|trim');
				$this->form_validation->set_rules('password', 'Password', 'required|trim');

			if ($this->form_validation->run() == false){
				$data['title'] = 'Login';
				$this->load->view('templates/auth/header',$data);
				$this->load->view('auth/login');
				$this->load->view('templates/auth/footer');
			}
			else{
				$this->_login();
			}
		}
	}

	private function _login(){
		//Form Validation Rules
			$username = $this->input->post('username');
			$password = $this->input->post('password');

		//get user in db
		$user = $this->M_model->getOne_where(['username' => $username], 'ecrm_users');
		
		// User exist
		if ($user) {
			
			// User active
			if ($user['status'] == 1) {
				
				// password true
				if (password_verify($password, $user['password'])) {
					
					$data = [
						'username' => $user['username'],
						'id_role' => $user['id_role']
					];

					$this->session->set_userdata($data);

					if ($user['id_role'] == 1) {
						redirect('Admin');
					}
					else{
						redirect('User');
					}
				}
				else{
					$this->session->set_flashdata('message', '
						<div class="alert alert-danger" role="alert">
		  					Worng password.
						</div>'
					);
					redirect('Auth');
				}
			}
			else{
				$this->session->set_flashdata('message', '
					<div class="alert alert-danger" role="alert">
	  					Please activate your account before login.
					</div>'
				);
				redirect('Auth');
				}
		}
		else{
			$this->session->set_flashdata('message', '
				<div class="alert alert-danger" role="alert">
  					username is not registred, please <a href="'.base_url('Auth/register').'">register</a>.
				</div>'
			);
			redirect('Auth');
		}
	}

	public function changePassword(){

		if (!$this->session->userdata('reset_email')) {
			redirect('Auth');
		}


		$this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[3]|matches[pass2]');
		$this->form_validation->set_rules('pass2', 'Confirm Password', 'trim|required|matches[pass1]');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Change Password';
			$this->load->view('templates/auth/header',$data);
			$this->load->view('auth/changePassword');
			$this->load->view('templates/auth/footer');
		}
		else{
			$password = password_hash($this->input->post('pass1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('absensi_users');

			$this->session->unset_userdata('reset_email');

			$this->db->delete('absensi_user_token', ['email', $email]);

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
						Password has been change, please login.
				</div>'
			);
			redirect('Auth');
		}
	}

	public function logout(){
		$username = $this->session->userdata('username');
		if ( empty($username) ) {
			$this->_Redirect();
		}
		else{
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('id_role');

			$this->session->set_flashdata('message', '
				<div class="alert alert-success" role="alert">
						Logged out.
				</div>'
			);
			redirect('Auth');
		}
	}

	public function blocked(){
		redirect('Page/Forbidden403','refresh');
	}
}