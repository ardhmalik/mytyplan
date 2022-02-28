<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth is child of CI_Controller
 * @author Malik Ardhiansyah
 * @description This controller acts as a link between models and views
 * @return functions Used by view
 */
class Auth extends CI_Controller
{
	/**
	 * @todo initialize all function needed
	 * @access public
	 * @description This function used to load library 
	 * 'form_validation' and load model 'Auth_model' as 'amodel'
	 * @see https://codeigniter.com/userguide3/general/creating_libraries.html?highlight=construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('unit_test');
		$this->load->model('auth_model', 'amodel');
	}

	/**
	 * Running the unit test process
	 * @access private
	 * @param array $test
	 * @param array $expected
	 * @param string $test_name
	 * @return void
	 */
	private function _unit_test($test, $expected, $test_name)
	{
		# $test_run variable to store result unit test
		$test_run = $this->unit->run($test, $expected, $test_name);
		# Show result
		echo $test_run;
		die;
	}
	
	private function _del_avatar($file)
	{
		return array_map('unlink', glob(FCPATH . "assets/img/user/$file.*"));
	}

	/**
	 * Navigate to login page
	 * @access public
	 * @description Show login page if don't have 'email' session saved
	 * @return view login page
	 */
	public function login()
	{
		# $amodel variable to shorten model call 'amodel'
		$amodel = $this->amodel;
		# $validation variable to shorten form_validation library
		$validation = $this->form_validation;
		# Initialize login rules with login_rules()
		$validation->set_rules($amodel->login_rules());
		
		# IF condition to check if there is a stored 'email' session
		if ($this->session->userdata('email')) {
			# If TRUE, add an wrong password alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still logged in, please <a href="'. site_url('logout') .'" class="alert-link">Logout</a>..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to dashboard page
			redirect('dashboard');
		}

		# $data variable to store array of data passed to login page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Login'
		];
		
		# IF condition to check form_validation not running
		if ($validation->run() == FALSE) {
			# If TRUE, it will be load login page
			$this->load->view('auth/header', $data);
			$this->load->view('auth/login', $data);
			$this->load->view('auth/footer');
		} else {
			# If FALSE, it will be load private function _login()
			$this->_login();
		}
	}

	/**
	 * Process of login
	 * @todo Processing login account
	 * @access private
	 * @return view dashboard and return login page if login failed
	 */
	private function _login()
	{
		# $session variable to save field email & username from user
		$data = [
			'email'=>$this->input->post('email'),
			'password'=>$this->input->post('password')
		];
		# $user variable returns user row array data value as per email in the stored session
		$user = $this->amodel->get_user_by_email($data['email']);

		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'email'=>'minato@konoha.com',
			'password'=>"Minato123"
		];

		# run unit_test with function _unit_test
		// $this->_unit_test($data, $expected_result, "Form login test");

		// var_dump($user);
		// die;
		
		# IF condition to check if user data exists
		if ($user) {
			# IF condition to check whether entered password matches user data
			if (password_verify($data['password'], $user['password'])) {
				# $data variable to save field email & username from $user
				$data = [
					'email'=>$user['email'],
					'username'=>$user['username']
				];
				# Add $data values to session
				$this->session->set_userdata($data);
				# It will be returned to dashboard page
				redirect('dashboard');
			} else {
				# If password is not matches, will be send wrong password message
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Wrong password bro, try again!
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
				# It will be returned to login page
				redirect('login');
			}
		} else {
			# If there is no user data, will be send email isn't registered message
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Email isn`t registered, please 
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<a href="'.site_url('register').'">Register here</a>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}
	}
	
	/**
	 * Navigate to register page
	 * @access public
	 * @description Loading register page
	 * @return view register
	 */
	public function register()
	{
		# $amodel variable to shorten model call 'amodel'
		$amodel = $this->amodel;
		# $sessions variable to shorten session method
		$sessions = $this->session;
		# $validation variable to shorten form_validation library
		$validation = $this->form_validation;
		# Initialize registration rules with reg_rules()
		$validation->set_rules($amodel->reg_rules());
		
		# IF condition to check if there is a stored 'email' session
		if ($this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still logged in, please <a href="'. site_url('login') .'" class="alert-link">Logout</a>..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to dashboard page
			redirect('dashboard');
		}

		# $data variable to store array of data passed to register page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Register'
		];

		# IF condition to check form_validation not running
		if ($validation->run() == FALSE) {
			$this->load->view('auth/header', $data);
			$this->load->view('auth/register', $data);
			$this->load->view('auth/footer');
		} else {
			/**
			 * If form_validation runs, it will save input data to variable $input
			 * $input variable to store array of data passed to 'Auth_model'
			 * Add @param true in post() method to avoid XSS attack
			 * Add htmlspecialchars() method for change character to HTML entity
			 * Add password_hash() method to create a password hash
			 *  */ 
			$input = [
				'email'=>htmlspecialchars($this->input->post('email', true)),
				'username'=>htmlspecialchars($this->input->post('username', true)),
				'password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT)
			];

			// var_dump($input);
			// die;

			# Passing $input as a parameter of createUser() function to execute adding data to database
			$amodel->create_user($input);
			# Add an alert message to session if createUser() process is successful
			$sessions->set_flashdata(
				'message',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
					Your account has been registered, Please Login...
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		}
	}

	public function edit_profile()
	{
		$email = $this->session->userdata('email');
		$user = $this->amodel->get_user_by_email($email);
		# $file_name variable to store string email without dot
		$file_name = str_replace(['@', '.com'], ['_', ''], $email);
		# $config variable to store upload library settings
		$config = [
			'upload_path'=>FCPATH.'assets/img/user/',
			'allowed_types'=>'gif|jpg|jpeg|png',
			'file_name'=>$file_name,
			'overwrite'=>true,
			'max_size'=>1024, # Ukuran maksimal 1MB
			'max_width'=>1000, # Lebar maksimal dalam px
			'max_height'=>1000 # Tinggi maksimal dalam px
		];
		
		$this->load->library('upload', $config);
		
		$old_data = [
			'avatar'=>$user['avatar'],
			'username'=>$user['username']
		];
		$new_data = [
			'id_user'=>$this->input->post('id_user'),
			'username'=>$this->input->post('username')
		];
		
		if (!empty($_FILES['avatar']['name'])) {
			if (!$this->upload->do_upload('avatar')) {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">'
					. $error .
					'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
			} elseif (!is_null($new_data['id_user'])) {
				$uploaded_data = $this->upload->data();
				$data = [
					'id_user'=>$new_data['id_user'],
					'avatar'=>$uploaded_data['file_name'],
					'username'=>$new_data['username']
				];
				
				$this->amodel->update_user($data);
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-success alert-dismissible fade show" role="alert">
					Your profile was updated!
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
			}
		} elseif (!is_null($new_data['id_user']) && $old_data['username'] != $new_data['username']) {
			$data = [
				'id_user'=>$new_data['id_user'],
				'avatar'=>$old_data['avatar'],
				'username'=>$new_data['username'],
			];
			
			$this->amodel->update_user($data);
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
				Your profile was updated!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		} else {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-secondary alert-dismissible fade show" role="alert">
				Nothing changes!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		} 
		
		redirect('dashboard');
	}
	
	public function default_avatar()
	{
		$email = $this->session->userdata('email');
		$user = $this->amodel->get_user_by_email($email);
		
		$file_name = str_replace(['@', '.com'], ['_', ''], $email);
		$this->_del_avatar($file_name);
		
		$data = [
			'id_user'=>$this->input->post('id_user'),
			'avatar'=>null,
			'username'=>$user['username']
		];
		
		if ($this->amodel->update_user($data)) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
				Success to set default avatar!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		}
		
		redirect('dashboard');
	}
	
	/**
	 * Process of logout
	 * @todo Processing logout account and unset userdata on session
	 * @access public
	 * @return view login page
	 */
	public function logout()
	{
		# Process to unset all userdata 'email' and 'password' from session
		$this->session->sess_destroy();
	
		# Add an alert message to session if unset_userdata() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-info alert-dismissible fade show" role="alert">
				You have been logout, Please Login...
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to login page
		redirect('login');
	}
}