<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Village extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();

		$this->load->model('Kelurahan_model', 'kelurahan');
	}

	private $folder 	= 'Master Data';
	private $title 		= 'Kelurahan';
	private $table 		= 'kelurahan';
	private $primaryKey = 'md5(id_kelurahan)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'title' 		=> $this->title,
			'kecamatan'		=> $this->db->get('kecamatan')->result(),
			'puskesmas'		=> $this->db->get('puskesmas')->result(),
		];
		$this->library->view('master/index_kelurahan', $data);
	}

	public function show_datatables()
	{
		$data = $this->kelurahan->get_datatables();
		echo json_encode($data);
	}

	public function get_data($id = NULL)
	{
		$query = $this->kelurahan->get_data($id);

		$output = [
			'nama_kelurahan' => @$query->nama_kelurahan,
			'id_kecamatan'	 => @$query->id_kecamatan,
			'id_puskesmas'	 => @$query->id_puskesmas, 
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
		$query 	= $this->kelurahan->get_data($this->input->post('id_kelurahan'));

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('nama_kelurahan', 'Kelurahan', 'trim|required');
		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'trim|required');
		$this->form_validation->set_rules('id_puskesmas', 'Puskesmas', 'trim|required');
		$this->form_validation->set_message('required', '{field} harus diisi');
		$this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array(
					'nama_kelurahan' => form_error('nama_kelurahan'),
					'id_kecamatan' => form_error('id_kecamatan'),
					'id_puskesmas' => form_error('id_puskesmas'),
				),
			];

		} else {
			$data = [
				'nama_kelurahan' 	=> ucwords($this->input->post('nama_kelurahan')),
				'id_kecamatan'		=> $this->input->post('id_kecamatan'),
				'id_puskesmas'		=> $this->input->post('id_puskesmas')
			];

			if (@$query) {
				$this->db->update($this->table, $data, ['id_kelurahan' => $query->id_kelurahan]);
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

/* End of file Village.php */
/* Location: ./application/controllers/master/Village.php */
