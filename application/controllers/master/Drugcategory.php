<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drugcategory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Kategori Obat';
	private $table 		= 'obat_kategori';
	private $primaryKey = 'md5(id_obat_kategori)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
			'kategori'		=> $this->db->get('kategori')->result(),
			'obat'			=> $this->db->get('obat')->result(),
		];
		$this->library->view('master/index_kategori_obat', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Kategori_obat_model', 'kom');
		$data = $this->kom->get_datatables();
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
			'jumlah_obat' 	 => @$query->jumlah_obat,
			'id_kategori'	 => @$query->id_kategori,
			'id_obat'	 	 => @$query->id_obat,
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
		$query 	= $this->_get_data($this->input->post('id_obat_kategori'));
		$id 	= $this->input->post('id_obat_kategori');

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('jumlah_obat', 'Jumlah Obat', 'trim|required|numeric');
		$this->form_validation->set_rules('id_kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_rules('id_obat', 'Obat', 'trim|required');

		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
		$this->form_validation->set_message('numeric', '{field} hanya boleh berisi angka');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'jumlah_obat' 	=> form_error('jumlah_obat'),
					'id_kategori' 	=> form_error('id_kategori'),
					'id_obat' 		=> form_error('id_obat'),
				),
			];

		} else {
			$data = [
				'jumlah_obat' 	=> $this->input->post('jumlah_obat'),
				'id_kategori' 	=> $this->input->post('id_kategori'),
				'id_obat' 		=> $this->input->post('id_obat'),
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

/* End of file Drugcategory.php */
/* Location: ./application/controllers/master/Drugcategory.php */
