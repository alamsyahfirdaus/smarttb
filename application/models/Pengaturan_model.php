<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

	private $table		= 'setting';
	private $col_order 	= ['setting_id', 'setting_name', 'setting_value', 'setting_description', NULL];
	private $col_search = ['setting_id', 'setting_name', 'setting_value', 'setting_description'];
	private $order_by 	= ['setting_id' => 'ASC'];

	private function _get_query()
	{
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query  = $this->library->get_result($this->_get_query());
		$start 	= $this->input->post('start');
		$data 	= array();
		$no  	= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[]	= $field->setting_name == 'PRIVACY_POLICE' ? 'Kebijakan Privasi' : 'Ketentuan Layanan';
			$row[]	= $field->setting_value;
			// $row[]	= $field->setting_description ? $field->setting_description : '-';
			$row[]	= '<button type="button" onclick="edit_data(' . "'" . md5($field->setting_id) . "'" . ')" class="btn btn-primary text-center" title="Edit Pengaturan"><i class="fas fa-edit"></i></button>';
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

}

/* End of file Pengaturan_model.php */
/* Location: ./application/models/Pengaturan_model.php */