<?php

// setter and getter session
if (!function_exists('set_session')) {
	function set_session($data)
	{
		$ci = get_instance();
		$ci->session->set_userdata($data);
	}
}

if (!function_exists('get_session')) {
	function get_session($key = NULL)
	{
		$ci = get_instance();
		if ($key) {
			return $ci->session->userdata($key);
		} else {
			return $ci->session->userdata();
		}
	}
}

// unset session
if (!function_exists('unset_session')) {
	function unset_session($data)
	{
		$ci = get_instance();
		$ci->session->unset_userdata($data);
	}
}

if (!function_exists('is_logged_in')) {
	function is_logged_in()
	{
		if (!get_session('user_id')) {
			redirect('login');
		}
	}
}

if (!function_exists('forecast_category')) {
	function forecast_category($exclude)
	{
		if ($exclude === 'hourly,daily') {
			return 1;
		} else if ($exclude === 'current,daily') {
			return 2;
		} else if ($exclude === 'current,hourly') {
			return 3;
		}
	}
}
