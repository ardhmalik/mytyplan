<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function login()
	{
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Login'
		];
		
		$this->load->view('auth/header', $data);
		$this->load->view('auth/login', $data);
		$this->load->view('auth/footer');
	}
		
	public function register()
	{
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Register'
		];

		$this->load->view('auth/header', $data);
		$this->load->view('auth/register', $data);
		$this->load->view('auth/footer');
	}
}