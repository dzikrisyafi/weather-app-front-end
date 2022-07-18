<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Auth extends CI_Model
{
	public function login($data)
	{
		$url = 'http://localhost:5000/users/login';

		$curl = curl_init($url);

		// Set JSON data to POST
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		return json_decode($result);
	}

	public function register($data)
	{
		$url = 'http://localhost:5000/users/register';

		$curl = curl_init($url);

		// Set JSON data to POST
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		return json_decode($result);
	}
}
