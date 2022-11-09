<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nurse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();

		$this->load->model('Pmo_model', 'pmo');

	}

	private $folder 	= 'Pengawas Minum Obat';
	private $title 		= 'Pengawas Minum Obat';
	private $table 		= 'pengawas_minum_obat';
	private $primaryKey = 'md5(id_pmo)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'header' 		=> $this->title,
		];
		$this->library->view('pmo/index_pmo', $data);
	}

	public function show_datatables()
	{
		$data = $this->pmo->get_datatables();
		echo json_encode($data);
	}

	public function detail($id = NULL)
	{
		$query = $this->pmo->get_data($id);

		if (!@$query) {
			show_404();
		}

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Detail',
			'data'			=> $query,
		];

		$this->library->view('pmo/detail_pmo', $data);
	}

	public function addedit($id = NULL)
	{
		$query = $this->pmo->get_data($id);

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'data'			=> $query,
		];

		$this->library->view('pmo/addedit_pmo', $data);
	}

	public function save_data($id = NULL)
	{
		$query = $this->pmo->get_data($id);

		if (@$query) {
			$iu_email 	= $query->email != $this->input->post('email') ? "|is_unique[user.email]" : "";
			$iu_phone 	= $query->phone != $this->input->post('phone') ? "|is_unique[user.phone]" : "";
			$required	= '';
		} else {
			$iu_email 	= '|is_unique[user.email]';
			$iu_phone 	= '|is_unique[user.phone]';
			$required	= '|required';
		}

		$this->_set_validation($iu_email, $iu_phone, $required);

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

					'pekerjaan' 	=> form_error('pekerjaan'),
					'alamat' 		=> form_error('alamat'),
				),
			];

		} else {
			$user = $this->db->get_where('user', ['user_id' => @$query->user_id])->row();

			$data = [
				'full_name'		=> ucwords($this->input->post('full_name')),
				'gender'		=> $this->input->post('gender'),
				'email' 		=> htmlspecialchars($this->input->post('email')),
				'phone'	   		=> $this->input->post('phone'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'user_type_id'	=> 3,
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

				$this->mall->update('user', ['user_id' => $user->user_id], $data);
				$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);
				$user_id = $user->user_id;

			} else {
				$data['password'] 		= md5($this->input->post('password1'));
				$data['date_created'] 	= date('Y-m-d H:i:s');
				$insert_id 	= $this->mall->insert('user', $data);
				$this->session->set_flashdata('success', 'Berhasil Menambah ' . $this->title);
				$user_id 	= $insert_id;
			}

			$this->_save_detail($query, $user_id);

			$output['status'] = TRUE;
		}

		$this->library->output_json($output);
	}

	private function _set_validation($iu_email, $iu_phone, $required)
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $iu_email);
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required|min_length[11]|numeric' . $iu_phone, ['min_length' => 'Telepon minimal {param} angka']);
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[8]' . @$required, ['min_length' => 'Password minimal {param} karakter']);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|min_length[8]|matches[password1]' . @$required, ['min_length' => 'Konfirmasi Password minimal {param} karakter']);

		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');
		$this->form_validation->set_message('matches', 'Konfirmasi Password tidak sama');
		$this->form_validation->set_message('valid_email', '{field} tidak valid');
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

	private function _save_detail($query = NULL, $user_id)
	{
		$data = [
			'user_id'		=> $user_id,
			'pekerjaan'		=> $this->input->post('pekerjaan'),
			'alamat_pmo'	=> $this->input->post('alamat'),
		];

		if (@$query) {
			$this->db->update($this->table, $data, ['id_pmo' => $query->id_pmo]);
		} else {
			$this->db->insert($this->table, $data);
		}
	}


}

/* End of file Nurse.php */
/* Location: ./application/controllers/Nurse.php */
