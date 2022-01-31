<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'amodel');
	}

	public function dashboard()
	{
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Dashboard',
			'user'=>$this->amodel->getUser($sessions['email'])
		];

		$this->load->view('sections/header', $data);
        $this->load->view('sections/navbar', $data);
		$this->load->view('sections/main', $data);
		$this->load->view('sections/footer');
	}
}