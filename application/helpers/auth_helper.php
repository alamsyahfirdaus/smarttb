<?php

	function logged_in()
	{
		$CI =& get_instance();
		if (!$CI->session->user_id) {
			redirect('login');
		} elseif ($CI->session->user_type != 1) {
			redirect('home');
		}
	}

	function logout()
	{
		$CI =& get_instance();
		if ($CI->session->user_id) {
			redirect('home');
		}
	}


/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */
