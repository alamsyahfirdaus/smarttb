<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		logged_in();

	}

	private $folder 	= 'Pengaturan';
	private $title 		= 'Pengaturan';
	private $table 		= 'setting';
	private $primaryKey = 'md5(setting_id)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'header' 		=> $this->title,
		];
		$this->library->view('pengaturan/index_pengaturan', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Pengaturan_model', 'setting');
		$data = $this->setting->get_datatables();
		echo json_encode($data);
	}

	public function edit($id = NULL)
	{
		$query = $this->db->get_where('setting', ['md5(setting_id)' => $id])->row();

		if (!$query) {
			show_404();
		}

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Edit',
			'data'			=> @$query,
			'setting_name'	=> $query->setting_id == 1 ? 'Kebijakan Privasi' : 'Ketentuan Layanan', 
		];

		$this->library->view('pengaturan/edit_pengaturan', $data);
	}

	public function save_data()
	{
		if (!$this->input->post('setting_name')) {
			show_404();
		} else {
			$this->db->update($this->table, ['setting_value' => $this->input->post('setting_value')], ['setting_name' => $this->input->post('setting_name')]);
		}

		$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);
		echo json_encode(['status' => TRUE]);
	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/Setting.php */
