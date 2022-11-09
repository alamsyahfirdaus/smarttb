<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drug extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Obat';
	private $table 		= 'obat';
	private $primaryKey = 'md5(id_obat)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('master/index_obat', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Obat_model', 'obat');
		$data = $this->obat->get_datatables();
		echo json_encode($data);
	}

	private function _get_data($id)
	{
		$query = $this->mall->get_data($this->table, [$this->primaryKey => $id]);
		return $query->row();
	}

	public function delete($id = NULL)
	{
		$where 	= array($this->primaryKey => $id);
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus ' . $this->title,
		];
		$this->library->output_json($output);
	}

	public function save_data()
	{
		$query 	= $this->_get_data($this->input->post('id_obat'));
		$id 	= $this->input->post('id_obat');

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nama_obat', 'Nama Obat', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'nama_obat' => form_error('nama_obat'),
				),
			];

		} else {
			$data = [
				'nama_obat' 	=> ucwords($this->input->post('nama_obat')),
			];

			if (@$query) {
				$this->db->update($this->table, $data, [$this->primaryKey => $id]);
				$set_message = 'Berhasil Mengubah ' . $this->title;
			} else {
				$this->db->insert($this->table, $data);
				$set_message = 'Berhasil Menambah ' . $this->title;
			}

			$output = [
				'status' 	=> TRUE,
				'message'	=> $set_message,
			];

		}

		$this->library->output_json($output);

	}


}

/* End of file Drug.php */
/* Location: ./application/controllers/master/Drug.php */
