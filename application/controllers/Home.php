<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->user_id) {
			redirect('login');
		}
		
		$this->form_validation->set_error_delimiters('', '');
	}

	private $folder = 'Beranda';
	private $table  = 'user';


	public function index()
	{
		$data['breadcrumb']  	= $this->folder;
		if ($this->session->user_type == 1) {
			$data['penderita']  	= $this->db->count_all_results('penderita');
			$data['pmo']  			= $this->db->count_all_results('pengawas_minum_obat');
			$data['tb_6']  			= $this->_countJenisPenderita(1);
			$data['tb_12']  		= $this->_countJenisPenderita(2);
			$data['tb_24']  		= $this->_countJenisPenderita(3);
			$data['belum_diatur']  	= $this->_belumDiatur();
			$this->library->view('home_view', $data);
		} else {
			$query = $this->_countPmoPenderita();

			$data['penderita']  	= $query['penderita'];
			$data['tb_6']  			= $query['tb_6'];
			$data['tb_12']  		= $query['tb_12'];
			$data['tb_24']  		= $query['tb_24'];
			$this->library->view('pmo_penderita/home_pmo', $data);
		}
	}

	private function _countJenisPenderita($id)
	{
		return $this->db->get_where('pengingat_obat', ['id_jenis_penderita' => $id])->num_rows();
	}

	private function _belumDiatur()
	{
		$penderita 		= $this->db->get_where('user', ['user_type_id' => 2])->num_rows();
		$belum_diatur	= $this->db->count_all_results('pengingat_obat');

		return $penderita - $belum_diatur;
	}

	private function _countPmoPenderita()
	{
		$query1 = $this->db->get_where('penderita', ['id_pmo' => $this->session->user_id]);

		$query2 = array();
		foreach ($query1->result() as $row) {
			$query2[] = $row->user_id;
		}

		$query3 = $this->db->where_in('user_id', @$query2)->where('id_jenis_penderita', 1)->get('pengingat_obat')->num_rows();
		
		$query4 = $this->db->where_in('user_id', @$query2)->where('id_jenis_penderita', 2)->get('pengingat_obat')->num_rows();
		$query5 = $this->db->where_in('user_id', @$query2)->where('id_jenis_penderita', 3)->get('pengingat_obat')->num_rows();

		$query = [
			'penderita' => $query1->num_rows(),
			'tb_6' 		=> $query3,
			'tb_12' 	=> $query4,
			'tb_24' 	=> $query5,
		];

		return $query;
	}

	public function profile()
	{
		$data   = [
			'breadcrumb' 	=> $this->folder, 
			'subtitle' 		=> 'Profile',
			'user' 			=> $this->library->session(),
		];
		
		$this->library->view('profile_index', $data);
	}

	public function editprofile()
	{
		$data = [
			'breadcrumb' 	=> $this->folder, 
			'subtitle' 		=> 'Profile',
			'user' 			=> $this->library->session(),
		];
		
		$this->library->view('profile_edit', $data);
	}

	public function editpassword()
	{
		$this->form_validation->set_rules('password', 'Password Lama', 'trim|required');
		$this->form_validation->set_rules('new_password1', 'Password Baru', 'trim|required|min_length[8]');

		$this->form_validation->set_rules('new_password2', 'Konfirmasi Password', 'trim|required|min_length[8]|matches[new_password1]', ['matches' => 'Konfirmasi Password tidak sama Password Baru']);

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('min_length', '{field} minimal {param} karakter');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'password' 		=> form_error('password'),
					'new_password1' => form_error('new_password1'),
					'new_password2' => form_error('new_password2')
				),
			];
			$this->library->output_json($data);
		} else {
			$user = $this->library->session();

			if ($user['password'] != md5($this->input->post('password'))) {
				$output = [
					'status'	=> FALSE,
					'errors'	=> array('password' => 'Password salah'),
				];
			} else {
				if ($user['password'] == md5($this->input->post('new_password1'))) {
					$output = [
						'status'	=> FALSE,
						'errors'	=> array('new_password1' => 'Password Baru tidak boleh sama dengan Password Lama'),
					];
				} else {
					$output = [
						'status' 	=> TRUE,
						'message'	=> 'Berhasil Mengubah Password',
					];
					$this->mall->update('user', array('user_id' => $user['user_id']), ['password' => md5($this->input->post('new_password1'))]);
				}
			}

			$this->library->output_json($output);
		}
	}

	public function save_editprofile($id = NULL)
	{
		$user = $this->mall->get_data('user', ['md5(user_id)' => $id])->row();

		if (!$user->user_id) {
			redirect('home/profile');
		}

		$iu_email = @$user->email == $this->input->post('email') ? "" : "|is_unique[user.email]";
		$iu_phone = @$user->phone == $this->input->post('phone') ? "" : "|is_unique[user.phone]";

		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $iu_email);
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required|min_length[11]|numeric' . $iu_phone);
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Tanggal Lahir', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('valid_email', '{field} tidak valid');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');
		$this->form_validation->set_message('min_length', '{field} minimal {param} angka');

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> FALSE,
				'errors'	=> array(
					'full_name'		=> form_error('full_name'),
					'username'		=> form_error('username'),
					'phone'			=> form_error('phone'),
					'gender'		=> form_error('gender'),
					'date_of_birth'	=> form_error('date_of_birth'),
				),
			];
			$this->library->output_json($data);
		} else {

			$data = [
				'full_name'		=> ucwords($this->input->post('full_name')),
				'gender'		=> $this->input->post('gender'),
				'email' 		=> htmlspecialchars($this->input->post('email')),
				'phone'	   		=> $this->input->post('phone'),
				'date_of_birth' => $this->input->post('date_of_birth'),
			];

			$this->_do_upload();
			if ($this->upload->do_upload('profile_pic')) {
			    if (@$user->profile_pic) {
			        unlink(IMAGE . $user->profile_pic);
			    }
			    $data['profile_pic'] = $this->upload->data('file_name');
			}

			$this->mall->update('user', ['user_id' => @$user->user_id], $data);

			$this->session->set_flashdata('success', 'Berhasil Mengubah Profile');
			$this->library->output_json(['status' => TRUE]);
		}
	}

	private function _do_upload()
	{
        $config['upload_path']   = 	UPLOAD_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|GIF|JPG|PNG|JPEG|BMP|';
        $config['max_size']    	 = 10000;
        $config['max_width']   	 = 10000;
        $config['max_height']  	 = 10000;
        $config['file_name']     = 'profile_pic_' . time();
        $this->upload->initialize($config);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
