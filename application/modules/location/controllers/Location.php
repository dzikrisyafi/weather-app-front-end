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
				'name' => 'Include',
				'rules' => 'required|trim'
			]
		];

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			$this->load->view('v_add_location', $data);
		} else {
			$data = [
				'lat' => (float)$this->input->post('lat'),
				'lon' => (float)$this->input->post('lon'),
				'exclude' => $this->input->post('exclude')
			];

			$response = $this->location->addLocation($data);
			if (isset($response->status) && $response->status === 'success') {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $response->message . '</div>');
				redirect('location');
			} else if (isset($response->status) && $response->status === 'fail') {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $response->message . '</div>');
				redirect('location');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Bad Request!</div>');
				redirect('location');
			}
		}
	}

	public function update()
	{
		$data = [
			'lat' => (float)$this->input->post('lat'),
			'lon' => (float)$this->input->post('lon'),
			'exclude' => $this->input->post('exclude')
		];

		$response = $this->location->updateLocation($data);
		if (isset($response->status) && $response->status === 'success') {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $response->message . '</div>');
			redirect('location');
		} else if (isset($response->status) && $response->status === 'fail') {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $response->message . '</div>');
			redirect('location');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Bad Request!</div>');
			redirect('location');
		}
	}
}
