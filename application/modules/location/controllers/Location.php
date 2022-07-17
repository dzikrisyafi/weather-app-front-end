<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('M_General', 'mdl');
		$this->load->model('M_Location', 'location');
	}

	public function index()
	{
		$data = [
			'title' => 'Saved Location',
			'locations' => $this->location->getAll()->result()
		];

		$this->load->view('v_location', $data);
	}

	public function add()
	{
		$data = [
			'title' => 'Add New Location',
		];

		$rules = [
			[
				'field' => 'lat',
				'name' => 'Latitude',
				'rules' => 'required|decimal'
			],
			[
				'field' => 'lon',
				'name' => 'Longitude',
				'rules' => 'required|decimal'
			],
			[
				'field' => 'exclude',
				'name' => 'Exclude',
				'rules' => 'required|trim'
			]
		];

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			$this->load->view('v_add_location', $data);
		} else {
			$data = [
				'lat' => $this->input->post('lat'),
				'lon' => $this->input->post('lon'),
				'exclude' => $this->input->post('exclude')
			];

			// check if location exists or not in database
			$isLocationExists = $this->mdl->countRows('weather_location', [
				'lat' => $data['lat'],
				'lon' => $data['lon'],
				'forecast_category' => forecast_category($data['exclude'])
			]);
			if ($isLocationExists) {
				// if location exists redirect to location/index
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Location already exists!</div>');
				redirect('location');
			}

			$locationWeathers = $this->location->getWeathers($data);
			if (isset($locationWeathers->hourly) || isset($locationWeathers->daily)) {
				$weathers = isset($locationWeathers->hourly) ? $locationWeathers->hourly : $locationWeathers->daily;
				$mapNewWeathers = [];
				foreach ($weathers as $weather) {
					$mapNewWeathers[] = [
						'id' => $weather->weather[0]->id,
						'main' => $weather->weather[0]->main,
						'description' => $weather->weather[0]->description,
					];
				}
				$this->db->update_batch('weathers', $mapNewWeathers, 'id');

				$locations = [];
				foreach ($weathers as $weather) {
					$locations[] = [
						'lat' => $locationWeathers->lat,
						'lon' => $locationWeathers->lon,
						'timezone' => $locationWeathers->timezone,
						'pressure' => $weather->pressure,
						'humidity' => $weather->humidity,
						'wind_speed' => $weather->wind_speed,
						'weather_id' => $weather->weather[0]->id,
						'forecast_category' => forecast_category($data['exclude']),
					];
				}

				$this->db->insert_batch('weather_location', $locations);

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New location has been added!</div>');
				redirect('location');
			} else {
				// check if weather exists or not in database
				$isWeatherExists = $this->mdl->countRows('weathers', ['id' => $locationWeathers->current->weather[0]->id]);
				if (!$isWeatherExists) {
					// if not exists then create new weather
					$weather = [
						'id' => $locationWeathers->current->weather[0]->id,
						'main' => $locationWeathers->current->weather[0]->main,
						'description' => $locationWeathers->current->weather[0]->description
					];

					$this->db->insert('weathers', $weather);
				}

				$location = [
					'lat' => $locationWeathers->lat,
					'lon' => $locationWeathers->lon,
					'timezone' => $locationWeathers->timezone,
					'pressure' => $locationWeathers->current->pressure,
					'humidity' => $locationWeathers->current->humidity,
					'wind_speed' => $locationWeathers->current->wind_speed,
					'weather_id' => $locationWeathers->current->weather[0]->id,
					'forecast_category' => 1,
				];

				$this->db->insert('weather_location', $location);

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New location has been added!</div>');
				redirect('location');
			}
		}
	}

	public function update()
	{
		$data = [
			'lat' => $this->input->post('lat'),
			'lon' => $this->input->post('lon'),
			'exclude' => $this->input->post('exclude')
		];

		// check if location exists or not in database
		$isLocationExists = $this->mdl->countRows('weather_location', [
			'lat' => $data['lat'],
			'lon' => $data['lon'],
			'forecast_category' => forecast_category($data['exclude'])
		]);
		if (!$isLocationExists) {
			// if location exists redirect to location/index
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Location not found!</div>');
			redirect('location');
		}

		$locationWeathers = $this->location->getWeathers($data);
		if (isset($locationWeathers->hourly) || isset($locationWeathers->daily)) {
			$weathers = isset($locationWeathers->hourly) ? $locationWeathers->hourly : $locationWeathers->daily;
			$mapNewWeathers = [];
			foreach ($weathers as $weather) {
				$mapNewWeathers[] = [
					'id' => $weather->weather[0]->id,
					'main' => $weather->weather[0]->main,
					'description' => $weather->weather[0]->description,
				];
			}
			$this->db->update_batch('weathers', $mapNewWeathers, 'id');

			$locations = $this->mdl->getWhere('id', [
				'lat' => $data['lat'],
				'lon' => $data['lon'],
				'forecast_category' => forecast_category($data['exclude'])
			], 'weather_location')->result();
			$newLocations = [];
			foreach ($weathers as $key => $weather) {
				$newLocations[] = [
					'id' => $locations[$key]->id,
					'lat' => $locationWeathers->lat,
					'lon' => $locationWeathers->lon,
					'timezone' => $locationWeathers->timezone,
					'pressure' => $weather->pressure,
					'humidity' => $weather->humidity,
					'wind_speed' => $weather->wind_speed,
					'weather_id' => $weather->weather[0]->id,
					'forecast_category' => forecast_category($data['exclude']),
				];
			}

			$this->db->update_batch('weather_location', $newLocations, 'id');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Location has been updated!</div>');
			redirect('location');
		} else {
			// check if weather exists or not in database
			$isWeatherExists = $this->mdl->countRows('weathers', ['id' => $locationWeathers->current->weather[0]->id]);
			if (!$isWeatherExists) {
				// if not exists then create new weather
				$weather = [
					'id' => $locationWeathers->current->weather[0]->id,
					'main' => $locationWeathers->current->weather[0]->main,
					'description' => $locationWeathers->current->weather[0]->description
				];

				$this->db->insert('weathers', $weather);
			}

			$location = $this->mdl->getWhere('id', [
				'lat' => $data['lat'],
				'lon' => $data['lon'],
				'forecast_category' => forecast_category($data['exclude'])
			], 'weather_location')->row();
			$newLocation = [
				'lat' => $locationWeathers->lat,
				'lon' => $locationWeathers->lon,
				'timezone' => $locationWeathers->timezone,
				'pressure' => $locationWeathers->current->pressure,
				'humidity' => $locationWeathers->current->humidity,
				'wind_speed' => $locationWeathers->current->wind_speed,
				'weather_id' => $locationWeathers->current->weather[0]->id,
				'forecast_category' => 1,
			];

			$this->db->update('weather_location', $newLocation, ['id' => $location->id]);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Location has been updated!</div>');
			redirect('location');
		}
	}
}
