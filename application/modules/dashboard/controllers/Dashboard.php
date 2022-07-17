<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('M_Location', 'location');
	}

	public function index()
	{
		// get current location
		$coordinate = explode(',', json_decode(file_get_contents('http://ipinfo.io/'))->loc);
		$lat = round($coordinate[0], 4);
		$lon = round($coordinate[1], 4);

		$data = [
			'title' => 'Dashboard',
			'lat' => $lat,
			'lon' => $lon,
			'current_weather' => $this->location->getForecastWeather([
				'lat' => $lat,
				'lon' => $lon,
				'exclude' => 'hourly,daily'
			])->data[0] ?? null,
			'hourly_weather' => $this->location->getForecastWeather([
				'lat' => $lat,
				'lon' => $lon,
				'exclude' => 'current,daily'
			])->data ?? null,
			'daily_weather' => $this->location->getForecastWeather([
				'lat' => $lat,
				'lon' => $lon,
				'exclude' => 'current,hourly'
			])->data ?? null
		];

		$this->load->view('v_dashboard', $data);
	}
}
