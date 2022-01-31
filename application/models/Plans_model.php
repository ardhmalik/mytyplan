<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans_model extends CI_Model
{
    public function getMonths()
    {
        $sql = $this->db->get('months');
        $query = $sql->result_array();

        return $query;
    }
    
    public function getPlans($id)
    {
        $sql = 'CALL viewAllPlan(?)';
        $query = $this->db->query($sql, ['id_user'=>$id])->result_array();

        return $query;
    }
}