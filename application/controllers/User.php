<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
		$this->form_validation->set_error_delimiters('', '');
		
	}

	private $folder 	= 'Administrator';
	private $title 		= 'Administrator';
	private $table 		= 'user';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'header'		=> $this->folder,
		];

		$this->library->view('index_user', $data);
	}

	public function show_datatables()
	{
		$this->load->model('User_model', 'user');
		$data = $this->user->get_datatables();
		echo json_encode($data);
	}

	public function addedit($user_id = NULL)
	{
		$query = $this->mall->get_data('user', ['md5(user_id)' => $user_id])->row();

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'header'		=> $this->title,
			'user'			=> $query,
			'user_type'		=> $this->db->get('user_type')->result(),
		];

		$this->library->view('addedit_user', $data);
	}
	
	public function save($user_id = NULL)
	{
		$user = $this->mall->get_data('user', ['md5(user_id)' => $user_id])->row();

		if (@$user) {
			$iu_email 	= $user->email != $this->input->post('email') ? "|is_unique[user.email]" : "";
			$iu_phone 	= $user->phone != $this->input->post('phone') ? "|is_unique[user.phone]" : "";
		} else {
			$iu_email 	= '|is_unique[user.email]';
			$iu_phone 	= '|is_unique[user.phone]';
			$required	= '|required';
		}

		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $iu_email);
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required|min_length[11]|numeric' . $iu_phone, ['min_length' => 'Telepon minimal {param} angka']);
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[8]' . @$required, ['min_length' => 'Password minimal {param} karakter']);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|min_length[8]|matches[password1]' . @$required, ['min_length' => 'Konfirmasi Password minimal {param} karakter']);


		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');
		$this->form_validation->set_message('matches', 'Konfirmasi Password tidak sama');
		$this->form_validation->set_message('valid_email', '{field} tidak valid');
		
		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'full_name'		=> form_error('full_name'),
					'email' 		=> form_error('email'),
					'phone' 		=> form_error('phone'),
					'gender' 		=> form_error('gender'),
					'date_of_birth' => form_error('date_of_birth'),
					'password1' 	=> form_error('password1'),
					'password2' 	=> form_error('password2'),
				),
			];

		} else {

			$data = [
				'full_name'		=> ucwords($this->input->post('full_name')),
				'gender'		=> $this->input->post('gender'),
				'email' 		=> htmlspecialchars($this->input->post('email')),
				'phone'	   		=> $this->input->post('phone'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'user_type_id'	=> 1,
			];

			$this->_do_upload();
			if ($this->upload->do_upload('profile_pic')) {
			    if (isset($user->profile_pic)) {
			        unlink(IMAGE . $user->profile_pic);
			    }
			    $data['profile_pic'] = $this->upload->data('file_name');
			}

			if (@$user) {
				if ($this->input->post('password1')) {
					$data['password'] = md5($this->input->post('password1'));
				}

				$this->mall->update($this->table, ['user_id' => $user->user_id], $data);
				$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);

			} else {
				$data['password'] 		= md5($this->input->post('password1'));
				$data['date_created'] 	= date('Y-m-d H:i:s');
				$this->mall->insert($this->table, $data);
				$this->session->set_flashdata('success', 'Berhasil Menambah ' . $this->title);
			}

			$output['status'] = TRUE;
		}

		$this->library->output_json($output);
	}

	private function _do_upload()
	{
        $config['upload_path']   = UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|GIF|JPG|PNG|JPEG|BMP|';
        $config['max_size']    	 = 10000;
        $config['max_width']   	 = 10000;
        $config['max_height']  	 = 10000;
        $config['file_name']     = 'image_' . time();
        $this->upload->initialize($config);
	}

	public function delete($id = NULL)
	{
		$where 	= array('md5(user_id)' => $id);
		$user 	= $this->mall->get_data($this->table, $where)->row();
		if (@$user->profile_pic) {
			unlink(IMAGE . $user->profile_pic);
		}
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus ' . @$user->full_name,
		];
		$this->library->output_json($output);
	}

	public function delete_img()
	{
		$where = ['md5(user_id)' => $this->input->post('user_id')];
		$user  = $this->mall->get_data($this->table, $where)->row();
		unlink(IMAGE . $user->profile_pic);
		$this->mall->update($this->table, $where, ['profile_pic' => NULL]);
		$output = [
			'status' 	=> TRUE,
			'message' 	=> 'Berhasil Menghapus Foto Profile',
		];
		$this->library->output_json($output);
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */