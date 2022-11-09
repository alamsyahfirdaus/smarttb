<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projection extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Proyeksi Penduduk';
	private $table 		= 'proyeksi_penduduk';
	private $primaryKey = 'md5(id_proyeksi_penduduk)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
		];
		$this->library->view('master/index_proyeksi_penduduk', $data);
	}

	public function show_datatables()
	{
		$this->load->model('ProyeksiPenduduk_model', 'proyeksi_penduduk');
		$data = $this->proyeksi_penduduk->get_datatables();
		echo json_encode($data);
	}

	private function _get_data($id)
	{
		$this->db->where($this->primaryKey, $id);
		return $this->db->get($this->table)->row();
	}

	public function addedit($id = NULL)
	{
		$query = $this->_get_data($id);

		$data = [
			'breadcrumb'	=> $this->folder,
			'title'			=> $this->title,
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'data'			=> $query,
			'puskesmas'		=> $this->db->get('puskesmas')->result(),
		];

		$this->_set_validation();

		if ($this->form_validation->run() == FALSE) {
			$this->library->view('master/addedit_proyeksi_penduduk', $data);
		} else {
			$this->_save_data(@$query->id_proyeksi_penduduk);
		}

	}

	private function _set_validation()
	{
		$this->form_validation->set_rules('tahun', '', 'trim|required');
		$this->form_validation->set_rules('id_puskesmas', '', 'trim|required');
		$this->form_validation->set_rules('jumlah_penduduk', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_periksa_dahak', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_diantara_semua', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_diantara_suspek', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_konversi', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_kesembuhan', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_cnr', '', 'trim|required|numeric');
		$this->form_validation->set_rules('target_cdr', '', 'trim|required|numeric');
	}

	private function _save_data($id = NULL)
	{
		$data = [
			'tahun' 					=> $this->input->post('tahun'),
			'id_puskesmas' 				=> $this->input->post('id_puskesmas'),
			'jumlah_penduduk' 			=> $this->input->post('jumlah_penduduk'),
			'target_periksa_dahak' 		=> $this->input->post('target_periksa_dahak'),
			'target_diantara_semua' 	=> $this->input->post('target_diantara_semua'),
			'target_diantara_suspek' 	=> $this->input->post('target_diantara_suspek'),
			'target_konversi' 			=> $this->input->post('target_konversi'),
			'target_kesembuhan'			=> $this->input->post('target_kesembuhan'),
			'target_cnr' 				=> $this->input->post('target_cnr'),
			'target_cdr' 				=> $this->input->post('target_cdr')
		];

		if (@$id) {
			$this->mall->update($this->table, [$this->primaryKey => $id], $data);
			$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);
		} else {
			$data['tanggal_data'] = date('Y-m-d H:i:s');
			$this->mall->insert($this->table, $data);
			$this->session->set_flashdata('success', 'Berhasil Menambah ' . $this->title);
		}

		redirect('master/projection');
	}

	public function delete($id = NULL)
	{
		$query = $this->_get_data($id);

		if (!@$query) {
			show_404();
		}

		$this->mall->delete($this->table, [$this->primaryKey => $id]);

		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus ' . $this->title,
		];
		$this->library->output_json($output);
	}
}

/* End of file Projection.php */
/* Location: ./application/controllers/master/Projection.php */
