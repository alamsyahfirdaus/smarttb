<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puskesmas_model extends CI_Model {

	private $table 		= 'puskesmas p';
	private $col_order	= ['id_puskesmas', 'nama_puskesmas', 'alamat', 'nama_kecamatan', NULL];
	private $col_search	= ['id_puskesmas', 'nama_puskesmas', 'alamat', 'nama_kecamatan'];
	private $order_by 	= ['id_puskesmas' => 'DESC'];


	private function _get_query()
	{
		$this->db->join('kecamatan k', 'k.id_kecamatan = p.id_kecamatan', 'left');
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 		= $this->library->get_result($this->_get_query());
		$start 		= $this->input->post('start');
		$data 		= array();
		$no  		= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[] 	= $field->kode_puskesmas;
			$row[] 	= ucwords($field->nama_puskesmas);
			$row[] 	= ucwords($field->nama_kecamatan);
			$row[] 	= $field->alamat;
			$row[] 	= $this->_get_button($field);
			$data[] = $row;
		}

		$output = [
			'draw' 					=> $this->input->post('draw'),
			'recordsTotal' 			=> $this->db->count_all_results($this->table),
			'recordsFiltered' 		=> $this->db->get($this->_get_query())->num_rows(),
			'data'					=> $data,
		];

		return $output;
	}

	private function _get_button($field)
	{
		$button		= '<div class="btn-group">';
		$button		.= '<button type="button" class="btn btn-primary">Action</button>';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">';
		$button		.= '<span class="sr-only">Toggle Dropdown</span>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right" role="menu">';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_puskesmas(' . "'" . md5($field->id_puskesmas) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_puskesmas(' . "'" . md5($field->id_puskesmas) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</button>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Puskesmas_model.php */
/* Location: ./application/models/Puskesmas_model.php */