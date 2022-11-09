	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

	public function __construct()
	{
		# PMO penderita

		parent::__construct();
		if (!$this->session->user_id) {
			redirect('login');
		} elseif ($this->session->user_type != 3) {
			redirect('home');
		}

		$this->load->model('Pmo_penderita_model', 'pmop');
		$this->load->model('Penderita_model', 'penderita');

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
		$this->library->view('pmo_penderita/index_pmo_penderita', $data);
	}

	public function show_datatables()
	{
		$data = $this->pmop->get_datatables();
		echo json_encode($data);
	}

	public function detail($id = NULL)
	{
		$query = $this->penderita->get_data($id);

		if (!@$query) {
			show_404();
		}

		$data = [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Detail',
			'data'			=> $query,
		];

		$this->library->view('pmo_penderita/detail_pmo_penderita', $data);
	}
}

/* End of file Patient.php */
/* Location: ./application/controllers/pmo/Patient.php */
