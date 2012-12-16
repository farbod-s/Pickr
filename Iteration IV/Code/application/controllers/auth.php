<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller
{
	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	function login()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('index.php/home/index');

		} else {
			$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('pass', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('user_remember_me', 'Remember me', 'integer');

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('name'),
						$this->form_validation->set_value('pass'),
						$this->form_validation->set_value('user_remember_me'),
						true,
						true)) {								// success

					echo json_encode(TRUE);
				}
				else {
					echo json_encode(FALSE);
				}
			}
			else {													// fail
				echo json_encode(FALSE);
			}
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();
		redirect('index.php/home/index');
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->tank_auth->is_logged_in()) { // logged in
			redirect('index.php/home/index');
		}
		else {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			if ($this->form_validation->run()) { // validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$this->form_validation->set_value('username'),
						$this->form_validation->set_value('email'), 
						$this->form_validation->set_value('password'),
						FALSE))) { // success

					unset($data['password']); // Clear password
					unset($data['confirm_password']); // Clear password
					
					echo json_encode(TRUE);
				}
				else {
					echo json_encode(FALSE);
				}
			}
			else {
				echo json_encode(FALSE);
			}
		}
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('index.php/home/index');
		}
		else {
			$this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_pass', 'Confirm new Password', 'trim|required|xss_clean|matches[new_pass]');

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_pass'),
						$this->form_validation->set_value('new_pass'))) {	// success
					echo json_encode(TRUE);

				} else {														// fail
					echo json_encode(FALSE);
				}
			}
			else {
				echo json_encode(FALSE);
			}
		}
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */