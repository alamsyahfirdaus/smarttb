<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edukasi_model extends CI_Model {

	private $table 			= 'edukasi';
	private $col_order 		= ['id_edukasi', 'title', NULL, NULL, NULL, NULL];
	private $col_search 	= ['id_edukasi', 'title'];
	private $order_by		= ['id_edukasi ' => 'DESC'];

	private function _get_query()
	{
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
			$row[]	= ucwords($field->title);
			$row[]	= '<p class="text-center"><img class="profile-user-img img-fluid" src="' . site_url(IMAGE . $this->library->image($field->image)) . '" alt="User profile picture"></p>';
			$row[]	= $field->type == 1 ? 'Artikel' : 'Video';
			$row[]	= '<p class="text-center">'. $this->_get_video($field->url) .'</p>';
			$row[]	= $field->is_active == 1 ? 'Aktif' : 'Nonaktif';
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
		$is_active  = $field->is_active == 1 ? 'Nonaktifkan' : 'Aktifkan';

		$button		= '<div class="btn-group">';
		$button		.= '<button type="button" class="btn btn-primary"><i class="fas fa-cogs	"></i></button>';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">';
		$button		.= '<span class="sr-only">Toggle Dropdown</span>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right" role="menu">';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="is_active(' . "'" . md5($field->id_edukasi) . "'" . ')">'. $is_active .'</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_data(' . "'" . md5($field->id_edukasi) . "'" . ')">Edit</a>';
		$button		.= '<div class="dropdown-divider"></div>';
		$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="delete_data(' . "'" . md5($field->id_edukasi) . "'" . ')">Hapus</a>';
		$button		.= '</div>';
		$button		.= '</button>';
		$button		.= '</div>';

		return $button;
	}

	private function _get_video($url)
	{
		$content = '';
		if ($url) {
			$content .= '<div class="timeline-body">';
			$content .= '<div class="embed-responsive embed-responsive-16by9">';
			$content .= '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'. $url .'" frameborder="0" allowfullscreen=""></iframe>';
			$content .= '</div>';
			$content .= '</div>';
		} else {
			$content .= '-';
		}

		return $content;
	}

}

/* End of file Edukasi_model.php */
/* Location: ./application/models/Edukasi_model.php */