<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Library
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
        date_default_timezone_set('Asia/Jakarta');
	}

	public function session()
	{
		$this->ci->db->join('user_type ut', 'ut.user_type_id = u.user_type_id', 'left');
		$this->ci->db->where('user_id', $this->ci->session->user_id);
		return $this->ci->db->get('user u')->row_array();
	}

	public function view($content, $data = NULL)
	{
		$page = ['content' => $this->ci->load->view('content/' . $content, $data, TRUE)];
		return $this->ci->load->view('section/page', $page);
	}

	public function navbar($content, $data = NULL)
	{
		$page = ['content' => $this->ci->load->view($content, $data, TRUE)];
		return $this->ci->load->view('student/page', $page);
	}

	// START LIBRARY DATATABLES

	public function datatables($col_order, $col_search, $order)
	{
		$start = 0;
		foreach ($col_search as $row) {
			if(@$_POST['search']['value']) {

				if($start === 0) {
					$this->ci->db->group_start();
					$this->ci->db->like($row, $_POST['search']['value']);
				} else {
					$this->ci->db->or_like($row, $_POST['search']['value']);
				}

				if(count($col_search) - 1 == $start)
					$this->ci->db->group_end();
			}
			$start++;
		}
		if(@$_POST['order']) {
			$this->ci->db->order_by($col_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(@$order) {
			$this->ci->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function _get_paging()
	{
		// DataTables
		if($this->ci->input->post('length') != -1)
		$this->ci->db->limit($this->ci->input->post('length'), $this->ci->input->post('start'));
	}

	public function get_result($query)
	{
		// DataTables
		$this->_get_paging();
		return $this->ci->db->get($query)->result();
	}

	public function output_json($data, $encode = TRUE)
	{
		if ($encode) $data = json_encode($data);
		$this->ci->output->set_content_type('application/json')->set_output($data);
	}

	// END DATATABLES

	public function null($value)
	{
	    if ($value) {
	        return $value;
	    } else {
	        return "-";
	    }
	}

	public function image($image)
	{
		if ($image) {
			return $image;
		} else {
			return 'blank.png';
		}
	}

	public function date($datetime = null)
	{
	    $months = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	    $year 	= substr(@$datetime, 0, 4);
	    $month 	= substr(@$datetime, 5, 2);
	    $date   = substr(@$datetime, 8, 2);

	    $result = @$date . " " . @$months[(int) $month - 1] . " " . @$year;
	    return (@$result);
	}

	public function get_moth()
	{
	    $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	    return $month;
	}


	public function tipe_penderita($id)
	{
	    switch ($id) {
	        case '1':
	            return 'Baru';
	            break;
	        case '2':
	            return 'Pindahan';
	            break;
	        case '3':
	            return 'Pengobatan';
	            break;
	        case '4':
	            return 'Kambuh';
	            break;
	        default:
	            return '-';
	            break;
	    }
	}

	public function hasil_berobat($id)
	{
		switch ($id) {
		    case '1':
		        return 'Ambil Obat';
		        break;
		    case '2':
		        return 'Konsultasi Dokter';
		        break;
		    case '3':
		        return 'Periksa Ulang  Dahak';
		        break;
		    default:
		        return '-';
		        break;
		}
	}

}

/* End of file Library.php */
/* Location: ./application/libraries/Library.php */