<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All_model extends CI_Model {

	public function insert($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function get_data($table, $where = NULL)
	{
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->get($table);
	}

	public function count_data($table, $where = NULL)
	{
		if ($where) {
			$this->db->where($where);
		} 
		return $this->db->count_all_results($table);
	}

	public function getSubMenu($user_type_id, $menu_id)
	{
	    $this->db->join('sub_menu sm', 'sm.sub_menu_id = ua.sub_menu_id', 'left');
	    $this->db->where('ua.user_type_id', $user_type_id);
	    $this->db->where('sm.menu_id', $menu_id);
	    $this->db->order_by('sm.url', 'asc');
	    $query 	= $this->db->get('user_access ua');
	    $data 	= array(
	        'num_rows' => $query->num_rows() > 0 ? TRUE : FALSE,
	        'result'   => $query->result(),
	    );

	    return $data;
	}
}

/* End of file All_model.php */
/* Location: ./application/models/All_model.php */