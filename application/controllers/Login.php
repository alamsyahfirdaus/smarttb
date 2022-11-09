<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	private $table = 'user';

	public function index()
	{
		logout();
		$data = array('title' => 'Login');

		$this->form_validation->set_rules('email', '', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', '', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login_view', $data);
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$user  = $this->mall->get_data($this->table, ['email' => $this->input->post('email')])->row();

		if ($user) {
			if ($user->user_type_id != 2) {
				if ($user->password == md5($this->input->post('password'))) {

					$this->session->set_userdata([
						'user_id' 	=> $user->user_id,
						'user_type' => $user->user_type_id
					]);
					
					$output['status'] = TRUE;
				} else {
					$output = [
						'status' 	=> FALSE,
						'error'		=> 'password',
						'message' 	=> 'Password Salah',
					];
				}
			} else {
				$output = [
					'status' 	=> FALSE,
					'message' 	=> 'Login Gagal',
				];
			}
		} else {
			$output = [
				'status' 	=> FALSE,
				'message' 	=> 'Email Belum Terdaftar',
			];
		}

		echo json_encode($output);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
