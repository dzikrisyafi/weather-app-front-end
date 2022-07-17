<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_General', 'mdl');
		$this->load->model('M_Auth', 'auth');
	}

	public function index()
	{
		show_404();
	}

	public function login()
	{
		if (get_session('user_id')) redirect('dashboard');
		$data = [
			'title' => 'Log in',
		];

		$rules = [
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|trim'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|trim'
			],
		];

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_login', $data);
		} else {
			$this->_auth();
		}
	}

	public function _auth()
	{
		$data = [
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
		];

		$response = $this->auth->login($data);

		if ($response->status === 'success') {
			$data = [
				'user_id' => $response->user->id,
				'name' => $response->user->name,
			];
			set_session($data);
			redirect('dashboard');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Login! Bad Request</div>');
			redirect('login');
		}
	}

	public function signup()
	{
		if (get_session('user_id')) redirect('dashboard');

		$data = [
			'title' => 'Sign up',
		];

		$rules = [
			[
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required|trim'
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|trim|is_unique[users.email]'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|trim|min_length[8]|matches[confirm_password]'
			],
			[
				'field' => 'confirm_password',
				'label' => 'Confirm Password',
				'rules' => 'required|trim|matches[password]'
			]
		];

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('v_signup', $data);
		} else {
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'confirm_password' => $this->input->post('confirm_password')
			];

			$response = $this->auth->register($data);

			if ($response->status === 'success') {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your account has been successfully created</div>');
				redirect('login');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Failed to create an account</div>');
				redirect('signup');
			}
		}
	}

	public function logout()
	{
		$data = [
			'user_id', 'name'
		];
		unset_session($data);
		redirect('login');
	}
}
