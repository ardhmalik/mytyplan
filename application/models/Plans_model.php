<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans_model extends CI_Model
{
    public function add_rules()
    {
        return [
            [
                'field'=>'plan',
                'label'=>'Plan',
                'rules'=>'required|trim'
            ], [
                'field'=>'expired',
                'label'=>'Expired',
                'rules'=>'required'
            ]
        ];
    }

    public function getMonths()
    {
        $sql = $this->db->get('months');
        $query = $sql->result_array();

        return $query;
    }

    public function getLabels()
    {
        $sql = $this->db->get('labels');
        $query = $sql->result_array();

        return $query;
    }
    
    public function getPlans($id)
    {
        $sql = 'CALL viewAllPlan(?)';
        $query = $this->db->query($sql, ['id_user'=>$id])->result_array();

        return $query;
    }

    public function createPlan($data)
    {
        $sql = 'SELECT addPlan(?, ?, ?, ?, ?, ?, ?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    public function updatePlan($data)
    {
        $sql = 'SELECT editPlan(?, ?, ?, ?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    public function successMark($data)
    {
        $sql = 'SELECT successPlan(?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    public function failMark($data)
    {
        $sql = 'SELECT failPlan(?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    public function movePlan($data)
    {
        $sql = 'SELECT movePlan(?, ?, ?)';
        $query = $this->db->query($sql, $data);

        return $query;
    }
    
    public function delPlan($data)
    {
        $sql = 'SELECT delPlan(?)';
        $query = $this->db->query($sql, $data);

        return $query;
    }

    public function getSplans($id)
    {
        $sql = 'CALL viewSuccessPlan(?)';
        $query = $this->db->query($sql, $id)->result_array();

        return $query;
    }
    
    public function getFplans($id)
    {
        $sql = 'CALL viewFailPlan(?)';
        $query = $this->db->query($sql, $id)->result_array();

        return $query;
    }

    public function getLogs($id)
    {
        $sql = $this->db->get_where('logs', ['id_user'=>$id]);
        $query = $sql->result_array();

        return $query;
    }
}