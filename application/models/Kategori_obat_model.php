<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_obat_model extends CI_Model {

	private $table 			= 'obat_kategori';
	private $col_order 		= ['id_obat_kategori', 'jumlah_obat', 'nama_kategori', 'nama_obat', NULL];
	private $col_search 	= ['id_obat_kategori', 'jumlah_obat', 'nama_kategori', 'nama_obat'];
	private $order_by		= ['id_obat_kategori ' => 'DESC'];

	private function _get_query()
	{
		$this->db->join('kategori', 'kategori.id_kategori = obat_kategori.id_kategori', 'left');
		$this->db->join('obat', 'obat.id_obat = obat_kategori.id_obat', 'left');
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
			$row[]	= $field->jumlah_obat;
			$row[]	= $field->nama_kategori;
			$row[]	= $field->nama_obat;
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
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_data(' . "'" . md5($field->id_obat_kategori) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_data(' . "'" . md5($field->id_obat_kategori) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</button>';
		$button		.= '</div>';

		return $button;
	}

}

/* End of file Kategori_obat_model.php */
/* Location: ./application/models/Kategori_obat_model.php */