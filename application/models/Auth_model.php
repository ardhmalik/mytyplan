<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
                'field'=>'email',
                'label'=>'Email',
                'rules'=>'required|trim|valid_email'
            ], [
                'field'=>'password',
                'label'=>'Password',
                'rules'=>'required|trim'
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
                'field'=>'username',
                'label'=>'Username',
                'rules'=>'required|trim|is_unique[users.username]',
                'errors'=>[
                    'is_unique'=>'Try another username'
                ]
            ], [
                'field'=>'email',
                'label'=>'Email',
                'rules'=>'required|trim|valid_email|is_unique[users.email]',
                'errors'=>[
                    'is_unique'=>'Email has already registered, try another email'
                ]
            ], [
                'field'=>'password',
                'label'=>'Password',
                'rules'=>'required|min_length[5]|trim',
                'errors'=>[
                    'min_length'=>'Password must have 5 character or more!'
                ]
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
     * Finds and returns a user data by email
     * @access public
     * @param string $email Contains email
     * @return row of user data
     */
    public function get_user_by_email($email)
    {
        $sql = $this->db->get_where('users', ['email'=>$email]);
        $query = $sql->row_array();

        return $query;
    }
}