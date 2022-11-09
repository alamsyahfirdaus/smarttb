<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	private $table 			= 'user u';
	private $col_order 		= ['user_id', 'full_name', 'email', NULL];
	private $col_search 	= ['user_id', 'full_name', 'email', 'phone'];
	private $order_by 		= ['user_id' => 'DESC'];

	private function _get_query()
	{
		$this->db->join('user_type ut', 'ut.user_type_id = u.user_type_id', 'left');
		$this->db->where('u.user_type_id', 1);
		$this->db->from($this->table);
		$this->library->datatables($this->col_order, $this->col_search, $this->order_by);
	}

	public function get_datatables()
	{
		$query 		= $this->library->get_result($this->_get_query());
		$data 		= array();
		$start 		= $this->input->post('start');
		$no  		= 1;
		foreach ($query as $field) {
			$start++;
			$row 	= array();
			$row[]  = $no++;
			$row[] 	= ucwords($field->full_name);
			$row[]	= '<p class="text-center"><img class="profile-user-img img-fluid" src="' . site_url(IMAGE . $this->library->image($field->profile_pic)) . '" alt="User profile picture"></p>';
			// $row[] 	= $field->email;
			// $row[]	= $field->gender == 'L' ? 'Laki-laki' : 'Perempuan';
			// $row[] 	= $this->library->date($field->date_of_birth);
			// $row[] 	= $field->phone;
			$row[] 	= $this->_get_detail($field);
			$row[]	= $this->_get_button($field);
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
		$button		.= '<button type="button" class="btn btn-primary"><i class="fas fa-cogs"></i></button>';
		$button		.= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">';
		$button		.= '<span class="sr-only">Toggle Dropdown</span>';
		$button		.= '<div class="dropdown-menu dropdown-menu-right" role="menu">';
		if ($this->session->user_id == $field->user_id) {
			$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="profile()">Profile</a>';
		} else {
			$button		.= '<a class="dropdown-item" href="javascript:void(0)" onclick="edit_user(' . "'" . md5($field->user_id) . "'" . ')">Edit</a>';
			$button		.= '<div class="dropdown-divider"></div>';
			$button		.= '<a class="dropdown-item"  href="javascript:void(0)" onclick="delete_user(' . "'" . md5($field->user_id) . "'" . ', ' . "'". $field->full_name . "'" . ')">Hapus</a>';
		}
		$button		.= '</div>';
		$button		.= '</button>';
		$button		.= '</div>';

		return $button;
	}

	private function _get_detail($field)
	{
		$gender = $field->gender == 'L' ? 'Laki-laki' : 'Perempuan';

		$detail = '<table class="table" style="width:100%">';
		$detail .= '<tr>';
		$detail .= '<td>Email</td>';
		$detail .= '<td>:</td>';
		$detail .= '<td>'. $field->email .'</td>';
		$detail .= '<tr>';
		$detail .= '<tr>';
		$detail .= '<td>Jenis Kelamin</td>';
		$detail .= '<td>:</td>';
		$detail .= '<td>'. $gender .'</td>';
		$detail .= '<tr>';
		$detail .= '<tr>';
		$detail .= '<td>Tanggal Lahir</td>';
		$detail .= '<td>:</td>';
		$detail .= '<td>'. $this->library->date($field->date_of_birth) .'</td>';
		$detail .= '<tr>';
		$detail .= '<tr>';
		$detail .= '<td>Telepon</td>';
		$detail .= '<td>:</td>';
		$detail .= '<td>'. $field->phone .'</td>';
		$detail .= '<tr>';
		$detail .= '</table>';

		return $detail;
	}

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */