<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Location extends CI_Model
{
	public function getAll()
	{
		$this->db->select('lat, lon, timezone, forecast_category');
		$this->db->from('weather_location');
		$this->db->group_by(['lat', 'lon', 'timezone', 'forecast_category']);
		return $this->db->get();
	}

	public function addLocation($data)
	{
		$url = 'http://localhost:5000/weathers';

		$curl = curl_init($url);

		// Set JSON data to POST
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);

		curl_close($curl);

		return json_decode($result);
	}

	public function updateLocation($data)
	{
		$url = 'http://localhost:5000/weathers';

		$curl = curl_init($url);

		// Set JSON data to POST
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);

		curl_close($curl);

		return json_decode($result);
	}

	public function getWeathers($data)
	{
		$url = 'https://api.openweathermap.org/data/2.5/onecall?lat=' . $data['lat'] . '&lon=' . $data['lon'] . '&exclude=' . $data['exclude'] . '&appid=1e033674960efb046604ee522f245012';
		return json_decode($this->curl->simple_get($url));
	}

	public function getForecastWeather($data)
	{
		$url = 'http://localhost:5000/weathers?lat=' . $data['lat'] . '&lon=' . $data['lon'] . '&exclude=' . $data['exclude'] . '';
		return json_decode($this->curl->simple_get($url));
	}
}
