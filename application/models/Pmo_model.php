<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmo_model extends CI_Model {

	private $table 			= 'pengawas_minum_obat';
	private $primaryKey 	= 'md5(id_pmo)';
	private $col_order 		= ['id_pmo', 'full_name', NULL, NULL, NULL];
	private $col_search 	= ['id_pmo', 'full_name', 'email', 'phone', 'pekejaan'];
	private $order_by		= ['id_pmo ' => 'DESC'];

	private function _join()
	{
		$this->db->join('user', 'user.user_id = pengawas_minum_obat.user_id', 'left');
		$this->db->where('user_type_id', 3);
	}

	private function _get_query()
	{
		$this->_join();
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 	= $this->library->get_result($this->_get_query());
		$data 	= array();
		$start 	= $this->input->post('start');
		$no  	= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[]	= ucwords($field->full_name);
			$row[]	= $field->gender == 'L' ? 'Laki-laki' : 'Perempuan';
			$row[]	= $field->phone;
			$row[]	= $field->pekerjaan;
			// $row[]	= $this->library->date($field->date_of_birth);
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
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="detail_data(' . "'" . md5($field->id_pmo) . "'" . ')">Detail</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_data(' . "'" . md5($field->id_pmo) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_data(' . "'" . md5($field->user_id) . "'" . ')">Hapus</a>';
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

}

/* End of file Pmo_model.php */
/* Location: ./application/models/Pmo_model.php */