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
		$data = [
			'title' => 'Dashboard',
		];

		$this->load->view('v_dashboard', $data);
	}

	public function get_current_weather()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$lat = round($this->input->get('lat'), 4);
		$lon = round($this->input->get('lon'), 4);

		$current_weather = $this->location->getForecastWeather([
			'lat' => $lat,
			'lon' => $lon,
			'exclude' => 'hourly,daily'
		])->data[0] ?? null;

		echo json_encode($current_weather);
	}

	public function get_hourly_weather()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$lat = round($this->input->post('lat'), 4);
		$lon = round($this->input->post('lon'), 4);

		$hourly_weather = $this->location->getForecastWeather([
			'lat' => $lat,
			'lon' => $lon,
			'exclude' => 'current,daily'
		])->data ?? null;

		$weathers = [];
		if ($hourly_weather) {
			foreach ($hourly_weather as $val) {
				$weathers[] = [
					'id' => $val->weather->id,
					'main' => $val->weather->main,
					'description' => $val->weather->description
				];
			}
		}

		echo json_encode(['data' => $weathers]);
	}

	public function get_daily_weather()
	{
		if (!$this->input->is_ajax_request()) show_404();

		$lat = round($this->input->post('lat'), 4);
		$lon = round($this->input->post('lon'), 4);

		$daily_weather = $this->location->getForecastWeather([
			'lat' => $lat,
			'lon' => $lon,
			'exclude' => 'current,hourly'
		])->data ?? null;

		$weathers = [];
		if ($daily_weather) {
			foreach ($daily_weather as $val) {
				$weathers[] = [
					'id' => $val->weather->id,
					'main' => $val->weather->main,
					'description' => $val->weather->description
				];
			}
		}

		echo json_encode(['data' => $weathers]);
	}
}
