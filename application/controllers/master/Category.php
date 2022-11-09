<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Kategori';
	private $table 		= 'kategori';
	private $primaryKey = 'md5(id_kategori)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('master/index_kategori', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Kategori_model', 'kategori');
		$data = $this->kategori->get_datatables();
		echo json_encode($data);
	}

	private function _get_data($id)
	{
		$query = $this->mall->get_data($this->table, [$this->primaryKey => $id]);
		return $query->row();
	}

	public function addedit($id = NULL)
	{
		$query = $this->_get_data($id);

		$data = [
			'breadcrumb'	=> $this->folder,
			'title'			=> $this->title,
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'data'			=> $query,
			'aturan'		=> $this->db->get('aturan')->result(),
		];

		$this->library->view('master/addedit_kategori', $data);
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

	public function save_data($id = NULL)
	{
		$query 	= $this->_get_data($id);

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required');
		$this->form_validation->set_rules('berat_badan', 'Berat Badan (Kg)', 'trim|required');
		$this->form_validation->set_rules('fase', 'Fase', 'trim|required');
		$this->form_validation->set_rules('id_aturan', 'Aturan Minum Obat', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'nama_kategori' 	=> form_error('nama_kategori'),
					'berat_badan' 		=> form_error('berat_badan'),
					'fase' 				=> form_error('fase'),
					'id_aturan' 		=> form_error('id_aturan'),
				),
			];

		} else {
			$data = [
				'nama_kategori' 	=> ucwords($this->input->post('nama_kategori')),
				'berat_badan' 		=> $this->input->post('berat_badan'),
				'fase' 				=> $this->input->post('fase'),
				'id_aturan' 		=> $this->input->post('id_aturan'),
			];

			if (@$query) {
				$this->db->update($this->table, $data, [$this->primaryKey => $id]);
				$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);
			} else {
				$this->db->insert($this->table, $data);
				$this->session->set_flashdata('success', 'Berhasil Menambah ' . $this->title);
			}

			$output['status'] = TRUE;

		}

		$this->library->output_json($output);

	}	
}

/* End of file Category.php */
/* Location: ./application/controllers/master/Category.php */
