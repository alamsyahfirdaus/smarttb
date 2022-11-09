<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// if (!$this->session->user_id) {
		// 	redirect('login');
		// } elseif ($this->session->user_type != 3) {
		// 	redirect('home');
		// }

		if (!$this->session->user_id) {
			redirect('login');
		}

	}

	private $folder 	= 'Penderita';
	private $title 		= 'Pesan Konsultasi';
	private $table 		= 'konsultasi';
	private $primaryKey = 'md5(konsultasi_id)';

	// public function index()
	// {
	// 	$data = [
	// 		'breadcrumb' 	=> 'Konsultasi',
	// 		'header' 		=> $this->title,
	// 	];
	// 	$this->library->view('pmo_penderita/index_home_pmo', $data);
	// }

	// public function show_datatables()
	// {
	// 	$sender_id = $this->session->user_id;

	// 	$this->load->model('Konsultasi_model', 'km');
	// 	$data = $this->km->get_datatables($sender_id);
	// 	echo json_encode($data);
	// }

	public function delete($id = NULL)
	{
		$where 	= array($this->primaryKey => $id);
		$this->mall->delete($this->table, $where);
		$output = [
			'status' => TRUE,
			'message' => 'Berhasil Menghapus Pesan',
		];
		$this->library->output_json($output);
	}

	public function broadcast_message()
	{
		if (!$this->input->post('message')) {
			show_404();
		} else {
			$query = $this->db->where('user_type_id', 2)->group_by('user_id')->get('user')->result();
			foreach ($query as $row) {
				$data[] = array(
					'sender_id' 	=> $this->session->user_id,
					'received_id'	=> $row->user_id,
					'date'			=> date('Y-m-d H:i:s'),
					'message'		=> $this->input->post('message'),
					'status_id'		=> '1' 
				);

				$this->db->insert_batch('konsultasi', $data);
			}

			echo json_encode(['status' => TRUE]);
		}
	}

	public function send_message($received_id = NULL)
	{
		$query = $this->db->get_where('user', ['md5(user_id)' => $received_id])->row();

		if (!$query) {
			show_404();
		}

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('message', 'Pesan', 'trim|required');
		$this->form_validation->set_message('required', '{field} harus diisi');

		if ($this->form_validation->run() == FALSE) {
			$output = [
				'status'	=> FALSE,
				'errors'	=> array('message' => form_error('message')),
			];
		} else {
			$data = array(
				'sender_id' 	=> $this->session->user_id,
				'received_id'	=> $query->user_id,
				'date'			=> date('Y-m-d H:i:s'),
				'message'		=> $this->input->post('message'),
				'status_id'		=> '1' 
			);

			$this->db->insert($this->table, $data);

			$output['status'] = TRUE;
		}

		$this->library->output_json($output);

	}

	public function send($user_id = NULL)
	{	
		$this->_get_message($user_id);
		$this->_update_status($user_id);

		$data 	= [
			'breadcrumb'	=> $this->folder,
			'subtitle'		=> 'Pesan Konsultasi',
			'received_id'	=> $user_id,
		];

		$this->library->view('pmo_penderita/balas_pesan', $data);
	}

	private function _update_status($user_id)
	{
		$query = $this->db->get_where($this->table, [
			'md5(sender_id)'=> $user_id,  
			'received_id'	=> $this->session->user_id
		])->result();

		$action = array();
		foreach ($query as $row) {
			$action[] = $this->db->update($this->table, ['status_id' => '2'], ['konsultasi_id' => $row->konsultasi_id]);	
		}

		return $action;
	}

	private function _get_message($user_id)
	{
		
		$query 	= $this->db->get_where('user', ['md5(user_id)' => $user_id])->row();

		if (!$query) {
			show_404();
		} else {
			return $this->db->where_in('sender_id', [$query->user_id, $this->session->user_id])->get($this->table);
		}
	}

	public function get_message($user_id = NULL)
	{
		$query 	= $this->_get_message($user_id);

		$content = '';

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$user = $this->db->get_where('user', ['user_id' => $row->sender_id])->row();

				$content .= '<div class="post">';
				$content .= '<div class="user-block">';
				$content .= '<img class="img-circle img-bordered-sm" src="'. base_url(IMAGE . $this->library->image(@$user->profile_pic)) .'" alt="user image">';
				$content .= '<span class="username">';
				$content .= '<a href="javascript:void(0)">'. ucwords($user->full_name) .'</a>';
				$content .= ' <a href="javascript:void(0)" onclick="delete_massage(' . "'" . md5($row->konsultasi_id) . "'" . ');" title="Hapus" class="float-right btn-tool"><i class="fas fa-times"></i></a>';
				$content .= '</span>';
				$content .= '<span class="description">'. @$row->date .'</span>';
				$content .= '</div>';
				$content .= '<p>'. @$row->message .'</p>';
				$content .= '</div>';
			}
		}

		$content .= '<form action="" method="post" id="form">';
		$content .= '<div class="form-group">';
		$content .= '<input type="hidden" name="received_id" value="">';
		$content .= '<div class="input-group input-group-sm">';
		$content .= '<input class="form-control" placeholder="Pesan" name="message" id="message" autocomplete="off">';
		$content .= '<div class="input-group-append">';
		$content .= '<button type="button" onclick="send_message();" id="btn_submit" class="btn btn-primary">Kirim</button>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '<small class="help-block text-danger"></small>';
		$content .= '</div>';
		$content .= '</form>';

		$output = array(
			'status'	 => TRUE, 
			'message'	 => $content,
		);
		echo json_encode($output);
	}

}

/* End of file Message.php */
/* Location: ./application/controllers/pmo/Message.php */
