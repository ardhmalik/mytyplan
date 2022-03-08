<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth_model is child of CI_Model
 * @author Malik Ardhiansyah
 * @description This model class as link between database and controllers
 * @return functions Used by Auth and Plans Controller
 */
class Auth_model extends CI_Model
{
    /**
     * Rules of login authentification 
     * @access public
     * @description Contains the login rules that the form_validation library will load
     * @return string [][]
     */
    public function login_rules()
    {
        return [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email'
            ], [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'
            ]
        ];
    }

    /**
     * Rules of registration authentification 
     * @access public
     * @description Contains the registration rules that the form_validation library will load
     * @return (string|string[])[][]
     */
    public function reg_rules()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|trim|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Try another username'
                ]
            ], [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'Email has already registered, try another email'
                ]
            ], [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[5]|trim',
                'errors' => [
                    'min_length' => 'Password must have 5 character or more!'
                ]
            ]
        ];
    }

    /**
     * Rules of change password 
     * @access public
     * @description Contains the change password rules
     * @return string [][]
     */
    public function change_pass_rules()
    {
        return [
            [
                'field' => 'curr_password',
                'label' => 'Current Password',
                'rules' => 'required'
            ], [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'required|trim|min_length[5]',
                'errors' => [
                    'min_length' => 'New Password must have 5 character or more!'
                ]
            ], [
                'field' => 'renew_password',
                'label' => 'Repeat Password',
                'rules' => 'required|matches[new_password]'
            ]
        ];
    }

    /**
     * Create and insert new user
     * @access public
     * @param string $data Containing an array of emails, usernames, passwords
     * @description A function that executes a query with a stored procedure 
     * 'addUser(email_param, username_param, password_param)'
     */
    public function create_user($data)
    {
        $sql = 'CALL addUser(?, ?, ?)';
        $query = $this->db->query($sql, $data);

        return $query;
    }

    /**
     * Update data user
     * @access public
     * @param string $data Containing an array of id_user, avatar, username
     * @description A function that executes a query with a stored procedure 
     * 'editser(id_user_param, avatar_param, username_param)'
     */
    public function update_user($data)
    {
        $sql = 'CALL editUser(?, ?, ?)';
        $query = $this->db->query($sql, $data);

        return $query;
    }

    /**
     * Finds and returns a user data by email
     * @access public
     * @param string $email Contains email
     * @return row of user data
     */
    public function get_user_by_email($email)
    {
        $sql = $this->db->get_where('users', ['email' => $email]);
        $query = $sql->row_array();

        return $query;
    }

    /**
     * Finds and returns all user data
     * @access public
     * @return array of user
     */
    public function get_all_users()
    {
        $sql = $this->db->get('users');
        $query = $sql->result_array();

        return $query;
    }

    /**
     * Finds and returns all user logs activity
     * @access public
     * @return array of user logs
     */
    public function get_user_logs()
    {
        $sql = $this->db->get('user_logs');
        $query = $sql->result_array();

        return $query;
    }

    /**
     * Processing change password
     * @access public
     * @param mixed $id_user and $new_pass
     * @return mixed
     */
    public function change_pass($id_user, $new_pass)
    {
        $this->db->set('password', $new_pass);
        $this->db->where('id_user', $id_user);
        $query = $this->db->update('users');

        return $query;
    }
}
