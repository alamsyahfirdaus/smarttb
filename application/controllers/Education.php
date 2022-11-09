<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// logged_in();
		if (!$this->session->user_id) {
			redirect('login');
		}
	}

	private $folder 	= 'Edukasi';
	private $title 		= 'Edukasi';
	private $table 		= 'edukasi';
	private $primaryKey = 'md5(id_edukasi)';

	public function index()
	{
		$data = [
			'breadcrumb' 	=> $this->folder,
			'header' 		=> $this->title,
		];
		$this->library->view('edukasi/index_edukasi', $data);
	}

	public function show_datatables()
	{
		$this->load->model('Edukasi_model', 'edukasi');
		$data = $this->edukasi->get_datatables();
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
			'subtitle'		=> @$query ? 'Edit' : 'Tambah',
			'data'			=> $query,
			'aturan'		=> $this->db->get('aturan')->result(),
		];

		$this->library->view('edukasi/addedit_edukasi', $data);
	}

	public function save_data($id = NULL)
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('title', 'Judul', 'trim|required');
		$this->form_validation->set_rules('type', 'Tipe Edukasi', 'trim|required');

		if ($this->input->post('type') == 1) {
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$output['status'] = FALSE;

			show_404();

		} else {
			$query = $this->_get_data($id);

			$data = [
				'title' 	=> ucwords($this->input->post('title')),
				'deskripsi' => $this->input->post('deskripsi'),
				'type'		=> $this->input->post('type')
			];

			if ($this->input->post('type') == 2) {
				$data['url'] = $this->input->post('url');
			} else {
				$data['url'] = NULL;
			}

			$this->_do_upload();
			if ($this->upload->do_upload('image')) {
			    if (@$query->image && file_exists(IMAGE . @$query->image)) {
			        unlink(IMAGE . $query->image);
			    }
			    $data['image'] = $this->upload->data('file_name');
			}

			if (@$query) {
				$this->db->update($this->table, $data, [$this->primaryKey => $id]);
				$this->session->set_flashdata('success', 'Berhasil Mengubah ' . $this->title);
			} else {
				$data['is_active'] = 1;

				$this->db->insert($this->table, $data);
				$this->session->set_flashdata('success', 'Berhasil Menambah ' . $this->title);
			}

			$output['status'] = TRUE;
		}

		$this->library->output_json($output);
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

	public function is_active($id = NULL)
	{
		$query = $this->_get_data($id);

		if (!@$query) {
			show_404();
		}

		$is_active = $query->is_active == 1 ? '0' : '1';

		$this->db->update($this->table, ['is_active' => $is_active], [$this->primaryKey => $id]);
		$this->session->set_flashdata('success', 'Berhasil Mengubah Status');
		redirect('education');

	}

}

/* End of file Education.php */
/* Location: ./application/controllers/Education.php */
