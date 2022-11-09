<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clinic extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Puskesmas';
	private $table 		= 'puskesmas';
	private $primaryKey = 'md5(id_puskesmas)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('master/index_puskesmas', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Puskesmas_model', 'puskesmas');
		$data = $this->puskesmas->get_datatables();
		echo json_encode($data);
	}

	// private function _get_data($id)
	// {
	// 	$this->db->where($this->primaryKey, $id);
	// 	return $this->db->get($this->table)->row();
	// }

	// public function get_kecamatan($id = NULL)
	// {
	// 	$query 	= $this->_get_data($id);
	// 	$output = [
	// 		'id_kecamatan'	 => md5($query->id_kecamatan),
	// 		'nama_kecamatan' => $query->nama_kecamatan
	// 	]; 
	// 	echo json_encode($output);
	// }

	// public function save_kecamatan()
	// {
	// 	$query 	= $this->_get_data($this->input->post('id_kecamatan'));

	// 	if (@$query->id_kecamatan) {
	// 		$iu_kecamatan 	= $query->nama_kecamatan == $this->input->post('nama_kecamatan') ? "" : "|is_unique[kecamatan.nama_kecamatan]";
	// 	} else {
	// 		$iu_kecamatan = '|is_unique[kecamatan.nama_kecamatan]';
	// 	}

	// 	$this->form_validation->set_error_delimiters('', '');
	// 	$this->form_validation->set_rules('nama_kecamatan', 'Kecamatan', 'trim|required' . $iu_kecamatan);
	// 	$this->form_validation->set_message('required', '{field} harus diisi');
	// 	$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

	// 	if ($this->form_validation->run() == FALSE) {
	// 		$output = [
	// 			'status'	=> FALSE,
	// 			'errors'	=> array(
	// 				'nama_kecamatan' => form_error('nama_kecamatan'),
	// 			),
	// 		];

	// 	} else {
	// 		$data = [
	// 			'nama_kecamatan' 	=> ucwords($this->input->post('nama_kecamatan')),
	// 		];

	// 		if (@$query->id_kecamatan) {
	// 			$this->db->update($this->table, $data, ['id_kecamatan' => $query->id_kecamatan]);
	// 			$set_message = 'Berhasil Mengubah ' . $this->title;
	// 		} else {
	// 			$data['tanggal_data'] = date('Y-m-d H:i:s');

	// 			$this->db->insert($this->table, $data);
	// 			$set_message = 'Berhasil Menambah ' . $this->title;
	// 		}

	// 		$output = [
	// 			'status' 	=> TRUE,
	// 			'message'	=> $set_message,
	// 		];

	// 	}

	// 	$this->library->output_json($output);
	// }

	// public function delete_kecamatan($id = NULL)
	// {
	// 	$where 	= array($this->primaryKey => $id);
	// 	$this->mall->delete($this->table, $where);
	// 	$output = [
	// 		'status' => TRUE,
	// 		'message' => 'Berhasil Menghapus ' . $this->title,
	// 	];
	// 	$this->library->output_json($output);
	// }
}

/* End of file Clinic.php */
/* Location: ./application/controllers/master/Clinic.php */
