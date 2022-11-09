<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dose extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Aturan Minum Obat';
	private $table 		= 'aturan';
	private $primaryKey = 'md5(id_aturan)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('master/index_aturan', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Aturan_minum_obat_model', 'amo');
		$data = $this->amo->get_datatables();
		echo json_encode($data);
	}

	private function _get_data($id)
	{
		$query = $this->mall->get_data($this->table, [$this->primaryKey => $id]);
		return $query->row();
	}

	public function get_data($id = NULL)
	{
		$query = $this->_get_data($id);

		$output = [
			'nama_aturan' 	 => @$query->nama_aturan,
			'deskripsi'	 	 => @$query->deskripsi,
		];

		echo json_encode($output);
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
		$query 	= $this->_get_data($this->input->post('id_aturan'));
		$id 	= $this->input->post('id_aturan');

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nama_aturan', 'Nama Aturan', 'trim|required');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'nama_aturan' 	=> form_error('nama_aturan'),
					'deskripsi' 	=> form_error('deskripsi'),
				),
			];

		} else {
			$data = [
				'nama_aturan' 	=> $this->input->post('nama_aturan'),
				'deskripsi' 	=> $this->input->post('deskripsi'),
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

/* End of file Dose.php */
/* Location: ./application/controllers/master/Dose.php */
