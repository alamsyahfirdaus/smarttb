<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();

		$this->load->model('Penderita_model', 'penderita');
		$this->load->model('Pmo_model', 'pmop');
	}

	private $folder 	= 'Penderita';
	private $title 		= 'Penderita';
	private $table 		= 'penderita';
	private $primaryKey = 'md5(id_penderita)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'header' 		=> $this->title,
		];
		$this->library->view('penderita/index_penderita', $data);
	}

	public function show_datatables()
	{
		$data = $this->penderita->get_datatables();
		echo json_encode($data);
	}

	public function detail($id = NULL)
	{
		$query = $this->penderita->get_data($id);

		if (!@$query) {
			show_404();
		}

		$pmop = $this->pmop->get_data(md5($query->id_pmo));

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Detail',
			'data'			=> $query,
			'pmop'			=> $pmop->full_name,
		];

		$this->library->view('penderita/detail_penderita', $data);
	}

	public function addedit($id = NULL)
	{
		$query = $this->penderita->get_data($id);

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'data'			=> $query,
			'gol_darah'		=> array('AB', 'A', 'B', 'O'),
			'kategori'		=> $this->db->get('kategori')->result(),
			// 'pmop'			=> $this->pmop->get_data(),
			'pmop'			=> $this->db->get_where('user', ['user_type_id' => 3])->result(),
		];

		$this->library->view('penderita/addedit_penderita', $data);
	}

	public function save_data($id = NULL)
	{
		$query = $this->penderita->get_data($id);

		if (@$query) {
			$iu_email 	= $query->email != $this->input->post('email') ? "|is_unique[user.email]" : "";
			$iu_phone 	= $query->phone != $this->input->post('phone') ? "|is_unique[user.phone]" : "";
			$iu_nik 	= $query->nik != $this->input->post('nik') ? "|is_unique[penderita.nik]" : "";
			$required	= '';
		} else {
			$iu_email 	= '|is_unique[user.email]';
			$iu_phone 	= '|is_unique[user.phone]';
			$iu_nik 	= '|is_unique[penderita.nik]';
			$required	= '|required';
		}

		$this->_set_validation($iu_email, $iu_phone, $iu_nik, $required);

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

					'nik' 			=> form_error('nik'),
					'umur' 			=> form_error('umur'),
					'berat_badan' 	=> form_error('berat_badan'),
					'tinggi_badan' 	=> form_error('tinggi_badan'),
					'gol_darah' 	=> form_error('gol_darah'),
					'id_pmo' 		=> form_error('id_pmo'),
					'id_kategori' 	=> form_error('id_kategori'),
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
				'user_type_id'	=> 2,
			];

			$this->_do_upload();
			if ($this->upload->do_upload('profile_pic')) {
			    if (isset($user->profile_pic)) {
			        @unlink(IMAGE . $user->profile_pic);
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

			$this->_save_penderita($query, $user_id);

			$output['status'] = TRUE;
		}

		$this->library->output_json($output);
	}

	private function _set_validation($iu_email, $iu_phone, $iu_nik, $required)
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $iu_email);
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required|min_length[11]|numeric' . $iu_phone, ['min_length' => 'Telepon minimal {param} angka']);
		$this->form_validation->set_rules('password1', 'Password', 'trim|min_length[8]' . @$required, ['min_length' => 'Password minimal {param} karakter']);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'trim|min_length[8]|matches[password1]' . @$required, ['min_length' => 'Konfirmasi Password minimal {param} karakter']);

		$this->form_validation->set_rules('nik', 'NIK', 'trim|required|min_length[16]|numeric' . $iu_nik, ['min_length' => 'NIK minimal {param} angka']);
		$this->form_validation->set_rules('umur', 'Umur', 'trim|required|numeric');
		$this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'trim|required|numeric');
		$this->form_validation->set_rules('berat_badan', 'Berat Badan', 'trim|required|numeric');
		$this->form_validation->set_rules('gol_darah', 'Golongan Darah', 'trim|required');
		// $this->form_validation->set_rules('id_kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_rules('id_pmo', 'Pengawas Minum Obat', 'trim|required');
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

	private function _save_penderita($query = NULL, $user_id)
	{
		$data = [
			'nik' 			=> $this->input->post('nik'),
			'umur'			=> $this->input->post('umur'),
			'tinggi_badan'	=> $this->input->post('tinggi_badan'),
			'berat_badan'	=> $this->input->post('berat_badan'),
			'gol_darah'		=> $this->input->post('gol_darah'),
			// 'id_kategori'	=> $this->input->post('id_kategori'),
			'id_pmo'		=> $this->input->post('id_pmo'),
			'alamat'		=> $this->input->post('alamat'),
		];

		if (@$query) {
			$this->db->update($this->table, $data, ['id_penderita' => $query->id_penderita]);
		} else {
			$data['user_id']	= $user_id;
			$this->db->insert($this->table, $data);
		}
	}

	# PENGINGAT MINUM OBAT

	public function alarm($id = NULL)
	{
		# Reminder Obat

		$query = $this->penderita->get_data($id);

		if (!@$query) {
			show_404();
		}

		$reminder_obat = $this->db->get_where('pengingat_obat', ['user_id' => @$query->user_id])->row();

		$data = [
			'breadcrumb'		=> $this->folder,
			'subtitle'			=> 'Reminder Obat',
			'data'				=> $query,
			'gol_darah'			=> array('AB', 'A', 'B', 'O'),
			'kategori'			=> $this->db->get('kategori')->result(),
			'pmop'				=> $this->pmop->get_data(),
			'reminder'			=> @$reminder_obat,
			'jenis_penderita'	=> $this->db->get('jenis_penderita')->result(),
			'sudah_minum_obat'	=> $this->db->get_where('riwayat', ['user_id' => $query->user_id])->num_rows(),
		];

		if (!$this->input->post('kode_penderita')) {
			$this->library->view('penderita/reminder_obat', $data);
		} else {
			$this->_save_alarm($reminder_obat, $query->user_id, $id);
		}

	}

	private function _save_alarm($query = NULL, $user_id, $id_penderita)
	{
		
		$jenis_tb 			= $this->input->post('id_jenis_penderita');
		$mulai_pengobatan 	= $this->input->post('tanggal_mulai');

		if ($jenis_tb == 1) {
			$time = '+6 month';
		} elseif ($jenis_tb == 2) {
			$time = '+1 year';
		} elseif ($jenis_tb == 3) {
			$time = '+2 year';
		}

		$data['jam_alarm']			= $this->input->post('jam_alarm');
		$data['deskripsi']			= $this->input->post('deskripsi');

		if (!@$query || date('Y-m-d') >= @$query->tanggal_selesai) {
			$data['id_jenis_penderita']	= $jenis_tb;
			$data['tanggal_mulai'] 		= $mulai_pengobatan;
			$data['tanggal_selesai'] 	= date('Y-m-d', strtotime($mulai_pengobatan . $time));
			$data['status'] 			= 1;
		}

		if (@$query) {
			$this->db->update('pengingat_obat', $data, ['reminder_id' => $query->reminder_id]);
			$message = 'Berhasil Mengubah Reminder Obat';
		} else {
			$data['user_id'] = $user_id;
			$this->db->insert('pengingat_obat', $data);
			$message = 'Berhasil Menambah Reminder Obat';
		}

		$this->session->set_flashdata('success', $message);
		redirect('patient/alarm/' . $id_penderita);
	}

	public function delete_alarm($reminder_id, $user_id)
	{
		$this->db->delete('pengingat_obat', ['md5(reminder_id)' => $reminder_id]);

		$query = $this->db->get_where('riwayat', ['md5(user_id)' => $user_id]);
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->db->delete('riwayat', ['id_riwayat' => $row->id_riwayat]);
			}
		}


		$this->session->set_flashdata('success', 'Berhasil Menghapus Reminder Obat');
		echo json_encode(['status' => TRUE]);
	}

}

/* End of file Patient.php */
/* Location: ./application/controllers/Patient.php */
