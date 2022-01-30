<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('auth_model');
	}

	public function login()
	{
		$auth = $this->auth_model;
		$validation = $this->form_validation;
		$validation->set_rules($auth->login_rules());
		
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Login'
		];
		
		if ($validation->run() == FALSE) {
			$this->load->view('auth/header', $data);
			$this->load->view('auth/login', $data);
			$this->load->view('auth/footer');
		} else {
			echo "You have successfully login!";
		}
	}
	
	public function register()
	{
		$auth = $this->auth_model;
		$validation = $this->form_validation;
		$validation->set_rules($auth->reg_rules());
		$sessions = $this->session;

		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Register'
		];

		if ($validation->run() == FALSE) {
			$this->load->view('auth/header', $data);
			$this->load->view('auth/register', $data);
			$this->load->view('auth/footer');
		} else {
			/**
			 * add true in post param to avoid XSS attack
			 * add htmlspecialchars() for change character to HTML entity
			 * add password_hash() for hash password
			 *  */ 
			$input = [
				'email'=>htmlspecialchars($this->input->post('email', true)),
				'username'=>htmlspecialchars($this->input->post('username', true)),
				'password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT)
			];

			// var_dump($input);
			// die;

			$auth->createUser($input);
			$sessions->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
				Your account has been registered, Please Login...
				</div>'
			);
			redirect('auth/login');
		}
	}
}