<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
		# Kill next process
		die;
	}

	/**
	 * Running the check role admin process
	 * @access private
	 * @param string $email
	 * @return mixed
	 */
	private function _check_role($email)
	{
		# IF Statement to add session userdata 'role' => 'admin' 
		if ($email == 'admin@mytyplan.com') {
			$data['role'] = "admin";
			return $this->session->set_userdata($data);
		}
	}

	/**
	 * Running process to delete avatar images
	 * @access private
	 * @param string $file
	 * @return array|false
	 */
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

		# IF statement to check if there is a stored 'email' session
		if ($this->session->userdata('email')) {
			# If TRUE, add an wrong password alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still logged in, please <a href="' . site_url('logout') . '" class="alert-link">Logout</a>..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to dashboard page
			redirect('dashboard');
		}

		# $data variable to store array of data passed to login page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Login'
		];

		# IF statement to check form_validation not running
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
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
		];
		# $user variable returns user row array data value as per email in the stored session
		$user = $this->amodel->get_user_by_email($data['email']);

		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'email' => 'minato@konoha.com',
			'password' => "Minato123"
		];

		# run unit_test with function _unit_test
		// $this->_unit_test($data, $expected_result, "Form login test");

		// var_dump($user);
		// die;

		# IF statement to check if user data exists
		if ($user) {
			# IF statement to check whether entered password matches user data
			if (password_verify($data['password'], $user['password'])) {
				# call _check_role() for role admin
				$this->_check_role($user['email']);
				# $data variable to save field email & username from $user
				$data = [
					'email' => $user['email'],
					'username' => $user['username']
				];
				# Add $data values to session
				$this->session->set_userdata($data);

				if (!$this->session->userdata('role')) {
					# It will be returned to dashboard page
					redirect('dashboard');
				} else {
					# It will be returned to admin dashboard page
					redirect('admin_dashboard');
				}
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
					<a href="' . site_url('register') . '">Register here</a>
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

		# IF statement to check if there is a stored 'email' session
		if ($this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still logged in, please <a href="' . site_url('login') . '" class="alert-link">Logout</a>..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to dashboard page
			redirect('dashboard');
		}

		# $data variable to store array of data passed to register page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Register'
		];

		# IF statement to check form_validation not running
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
				'email' => htmlspecialchars($this->input->post('email', true)),
				'username' => htmlspecialchars($this->input->post('username', true)),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
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

			redirect('login');
		}
	}

	/**
	 * Processing change password
	 * @access public
	 * @return void
	 */
	public function change_password()
	{
		# $amodel variable to shorten model call 'amodel'
		$amodel = $this->amodel;
		# $sessions variable to shorten session method
		$sessions = $this->session;
		# $validation variable to shorten form_validation library
		$validation = $this->form_validation;
		# Initialize registration rules with reg_rules()
		$validation->set_rules($amodel->change_pass_rules());

		# IF statement while form_validation not run
		if ($validation->run() == FALSE) {
			# Send validation error message with session flashdata
			$sessions->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">'
					. validation_errors() .
					'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		} else {
			# $user variable returns user row array data value as per email in the stored session
			$user = $amodel->get_user_by_email($sessions->userdata('email'));
			# $input variable to store value of form change password
			$input = [
				'id_user' => $this->input->post('id_user'),
				'curr_password' => $this->input->post('curr_password'),
				'new_password' => $this->input->post('new_password'),
				'renew_password' => $this->input->post('renew_password')
			];

			# IF statement to check whether entered password matches user data
			if (password_verify($input['curr_password'], $user['password'])) {
				# IF statement to check the new password match with the current password
				if ($input['new_password'] == $input['curr_password']) {
					# Send error message with session flashdata
					$sessions->set_flashdata(
						'message',
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">
							New password can`t be same to current password!
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>'
					);
				} else {
					# $new_pass variable to store result value of hashing new password
					$new_pass = password_hash($input['new_password'], PASSWORD_DEFAULT);
					# Passing $data['id_user'] and $new_pass as a parameter of change_pass() function to update data on database
					$amodel->change_pass($user['id_user'], $new_pass);

					# Send error message with session flashdata
					$sessions->set_flashdata(
						'message',
						'<div class="alert alert-success alert-dismissible fade show" role="alert">
						Password has ben changed!
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>'
					);
				}
			} else {
				# Send error message with session flashdata
				$sessions->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Wrong your current password bro, try again!
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
			}
		}

		# IF statement to specify page redirect with check session userdata 'role'
		if ($this->session->userdata('role')) {
			redirect('admin_profile');
		} else {
			redirect('dashboard');
		}
	}

	/**
	 * Navigate an admin profile page
	 * @access public
	 * @return void
	 */
	public function admin_profile()
	{
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Admin Profile',
			'user' => $user
		];

		// var_dump($data);
		// die;

		# IF statement to check if no 'email' session is stored
		if (!$this->session->userdata('email')) {
			# Send error message with session flashdata
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}
		# Load view main on folder sections and pass $data variable
		$this->load->view('admin/main', $data);
	}

	/**
	 * Processing edit_profile
	 * @access public
	 * @return void
	 */
	public function edit_profile()
	{
		# $email to getting email from session
		$email = $this->session->userdata('email');
		# $user variable returns user row array data value as per email in the stored session
		$user = $this->amodel->get_user_by_email($email);
		# $file_name variable to store string email without '@' and '.com'
		$file_name = str_replace(['@', '.com'], ['_', ''], $email);
		/**
		 * $config variable to store settings of upload library
		 * upload_path		=> Location to save file
		 * allowed_types	=> Uploadable file extension
		 * file_name		=> Saved upload file naming
		 * overwrite		=> Allow to overwrite the same file name
		 * max_size			=> Maximal file size on KB
		 * max_width		=> Maximal width of file on px
		 * max_height		=> Maximal height of file on px
		 */
		$config = [
			'upload_path' => FCPATH . 'assets/img/user/',
			'allowed_types' => 'gif|jpg|jpeg|png',
			'file_name' => $file_name,
			'overwrite' => true,
			'max_size' => 1024,
			'max_width' => 1000,
			'max_height' => 1000
		];

		# Initialize upload library
		$this->load->library('upload', $config);

		# $old_data variable to store old user data
		$old_data = [
			'avatar' => $user['avatar'],
			'username' => $user['username']
		];
		# $new_data variable to save value of id_user & username from user
		$new_data = [
			'id_user' => $this->input->post('id_user'),
			'username' => $this->input->post('username')
		];

		# IF statement to check field name on avatar arrays
		if (!empty($_FILES['avatar']['name'])) {
			# IF failed to upload avatar
			if (!$this->upload->do_upload('avatar')) {
				# $error variable to store value of error message from upload library
				$error = $this->upload->display_errors();
				# Send error message with session flashdata
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">'
						. $error .
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
			}
			# ELSEIF statement to check id_user is not null
			elseif (!is_null($new_data['id_user'])) {
				# $uploaded_data variable to store process upload data
				$uploaded_data = $this->upload->data();
				# $data variable to store data to be passed to the model
				$data = [
					'id_user' => $new_data['id_user'],
					'avatar' => $uploaded_data['file_name'],
					'username' => $new_data['username']
				];

				# Passing $data as a parameter of update_user() function to update data on database
				$this->amodel->update_user($data);
				# Send success message with session flashdata
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-success alert-dismissible fade show" role="alert">
						Your profile was updated!
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>'
				);
			}
		}
		# ELSEIF statement to check id_user is not null AND current username is not same with new username
		elseif (!is_null($new_data['id_user']) && $old_data['username'] != $new_data['username']) {
			# $data variable to store data to be passed to the model
			$data = [
				'id_user' => $new_data['id_user'],
				'avatar' => $old_data['avatar'],
				'username' => $new_data['username'],
			];

			# Passing $data as a parameter of update_user() function to update data on database
			$this->amodel->update_user($data);
			# Send success message with session flashdata
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
				Your profile was updated!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		} else {
			# Send info message with session flashdata
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-secondary alert-dismissible fade show" role="alert">
					Nothing changes!
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		}

		# IF statement to specify page redirect with check session userdata 'role'
		if ($this->session->userdata('role')) {
			redirect('admin_profile');
		} else {
			redirect('dashboard');
		}
	}

	/**
	 * Processing to set default avatar
	 * @access public
	 * @return void
	 */
	public function default_avatar()
	{
		# $email to getting email from session
		$email = $this->session->userdata('email');
		# $user variable returns user row array data value as per email in the stored session
		$user = $this->amodel->get_user_by_email($email);
		# $file_name variable to store string email without '@' and '.com'
		$file_name = str_replace(['@', '.com'], ['_', ''], $email);
		# Passing $file_name as a parameter of _del_avatar() function
		$this->_del_avatar($file_name);
		# $data variable to store data to be passed to the model
		$data = [
			'id_user' => $this->input->post('id_user'),
			'avatar' => null,
			'username' => $user['username']
		];

		# IF statement to check process update_user()
		if ($this->amodel->update_user($data)) {
			# Send error message with session flashdata
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success alert-dismissible fade show" role="alert">
				Success to set default avatar!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
		}

		# IF statement to specify page redirect with check session userdata 'role'
		if ($this->session->userdata('role')) {
			redirect('admin_profile');
		} else {
			redirect('dashboard');
		}
	}

	/**
	 * Process of logout
	 * @todo Processing logout account and unset userdata on session
	 * @access public
	 * @return view login page
	 */
	public function logout()
	{
		# $data variable to store items as array of userdata keys
		$data = ['email', 'username'];
		# $role variable to store result of role check ternary operation
		$role = ($this->session->userdata('role')) ? array_push($data, 'role') : '';
		# Unset all from session
		$this->session->unset_userdata($data);

		# Send success message with session flashdata
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
