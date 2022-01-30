<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
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

    public function createUser($data)
    {
        $sql = 'CALL addUser(?, ?, ?)';
        $query = $this->db->query($sql, [$data['email'], $data['username'], $data['password']]);

        return $query;
    }
}