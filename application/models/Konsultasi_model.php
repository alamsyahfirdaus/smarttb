<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi_model extends CI_Model {

	private $table 			= 'konsultasi';
	private $primaryKey 	= 'md5(konsultasi_id)';
	private $col_order 		= ['konsultasi_id', 'date', 'full_name', NULL];
	private $col_search 	= ['konsultasi_id', 'date', 'full_name'];
	private $order_by		= ['konsultasi_id ' => 'DESC'];

	private function _join()
	{
		$this->db->join('user', 'user.user_id = konsultasi.received_id', 'left');
	}

	private function _limit()
	{
		$limit = $this->input->post('length') + 1 + $this->input->post('start');
		$this->db->limit($limit);
	}

	private function _get_query($sender_id = NULL)
	{
		if ($this->session->user_type == 3) {
			$this->db->where('sender_id', $sender_id);
		}

		$this->_join();
		$this->_limit();	
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables($sender_id)
	{
		$query 	= $this->library->get_result($this->_get_query($sender_id));
		$data 	= array();
		$start 	= $this->input->post('start');
		$no  	= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[]	= ucwords($field->full_name);
			$row[]	= $field->message ? $field->message : '-';
			$row[]	= $this->library->date($field->date);
			$row[] 	= $this->_get_button($field);
			$data[]	= $row;
		}

		$output	= [
			'draw' 				=> $this->input->post('draw'),
			'recordsTotal'		=> $this->db->count_all_results($this->table),
			'recordsFiltered' 	=> $this->db->get($this->_get_query())->num_rows(),
			'data' 				=> $data,
		];

		return $output;
	}

	private function _get_button($field)
	{
		$button		= '<div class="btn-group">';
		$button		.= '<button type="button" class="btn btn-primary"><i class="fas fa-cogs	"></i></button>';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">';
		$button		.= '<span class="sr-only">Toggle Dropdown</span>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right" role="menu">';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="balas_pesan(' . "'" . md5($field->konsultasi_id) . "'" . ')">Balas</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		// $button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_data(' . "'" . md5($field->konsultasi_id) . "'" . ')">Edit</a>';
		// $button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapus_pesan(' . "'" . md5($field->konsultasi_id) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</button>';
		$button		.= '</div>';

		return $button;
	}

	public function get_data($id = NULL)
	{
		$this->_join();
		if ($id) {
			return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
		} else {
			return $this->db->get($this->table)->result();
		}
	}

	public function get_message($penderita = NULL, $pengawas = NULL)
	{
		$this->db->where_in('sender_id', [$penderita, $pengawas]);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Konsultasi_model.php */
/* Location: ./application/models/Konsultasi_model.php */