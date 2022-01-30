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
                'rules'=>'required|trim'
            ], [
                'field'=>'email',
                'label'=>'Email',
                'rules'=>'required|trim|valid_email'
            ], [
                'field'=>'password',
                'label'=>'Password',
                'rules'=>'required|min_length[5]|trim'
            ]
        ];
    }
}