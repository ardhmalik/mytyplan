<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plans_model is child of CI_Model
 * @author Malik Ardhiansyah
 * @description This model class as the link between database and controller
 * @return functions Used by Plans Controller
 */
class Plans_model extends CI_Model
{
    /**
     * Rules of add new plan 
     * @access public
     * @description Contains the add plan rules that the form_validation library will load
     * @return string [][]
     */
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

    /**
     * Finds and returns all month
     * @access public
     * @return array months data value
     */
    public function get_months()
    {
        $sql = $this->db->get('months');
        $query = $sql->result_array();

        return $query;
    }

    /**
     * Finds and returns all label
     * @access public
     * @return array labels data value
     */
    public function get_labels()
    {
        $sql = $this->db->get('labels');
        $query = $sql->result_array();

        return $query;
    }
    
    /**
     * Finds and returns plans by id_user
     * @access public
     * @param string $idUser Contains id_user
     * @description A function that executes a query with a SQL procedure 
     * 'viewAllPlan(id_user_param)'
     * @return array plans data value
     */
    public function get_plans_by_id($idUser)
    {
        $sql = 'CALL viewAllPlan(?)';
        $query = $this->db->query($sql, ['id_user'=>$idUser])->result_array();

        return $query;
    }

    /**
     * Create and insert a new plan
     * @access public
     * @param string $data Containing an array of id_user, plan, description, expired, status, id_label, id_month
     * @description A function that executes a query with a custom SQL function 
     * 'addPlan(id_user_param, plan_param, desc_param, exp_param, status_param, id_label_param, id_month_param)'
     * @return int 1 if the query insert is successful
     */
    public function create_plan($data)
    {
        $sql = 'SELECT addPlan(?, ?, ?, ?, ?, ?, ?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    /**
     * Finds and update a plan by id_plan
     * @access public
     * @param string $data Containing an array of id_plan, plan, description, id_label
     * @description A function that executes a query with a custom SQL function 
     * 'editPlan(id_plan_param, plan_param, desc_param, id_label_param)'
     * @return int 1 if the query update is successful
     */
    public function update_plan($data)
    {
        $sql = 'SELECT editPlan(?, ?, ?, ?)';
        $query = $this->db->query($sql, $data)->result_array();

        return $query;
    }
    
    /**
     * Finds and mark success plan
     * @access public
     * @param string $idPlan Contains id_plan
     * @description A function that executes a query with a custom SQL function 
     * 'successPlan(id_plan_param)'
     * @return int 1 if the query update is successful
     */
    public function mark_success_plan($idPlan)
    {
        $sql = 'SELECT successPlan(?)';
        $query = $this->db->query($sql, $idPlan)->result_array();

        return $query;
    }
    
    /**
     * Finds and mark fail plan
     * @access public
     * @param string $idPlan Contains id_plan
     * @description A function that executes a query with a custom SQL function 
     * 'failPlan(id_plan_param)'
     * @return int 1 if the query update is successful
     */
    public function mark_fail_plan($idPlan)
    {
        $sql = 'SELECT failPlan(?)';
        $query = $this->db->query($sql, $idPlan)->result_array();

        return $query;
    }
    
    /**
     * Finds and move plan to other month
     * @access public
     * @param string $data Containing an array of id_plan, month, expired
     * @description A function that executes a query with a custom SQL function 
     * 'movePlan(id_plan_param, month_param, exp_param)'
     * @return int 1 if the query update is successful
     */
    public function move_plan($data)
    {
        $sql = 'SELECT movePlan(?, ?, ?)';
        $query = $this->db->query($sql, $data);

        return $query;
    }
    
    /**
     * Finds and delete a plan
     * @access public
     * @param string $idPlan Contains id_plan
     * @description A function that executes a query with a custom SQL function 
     * 'delPlan(id_plan_param)'
     * @return int 1 if the query delete is successful
     */
    public function del_plan($idPlan)
    {
        $sql = 'SELECT delPlan(?)';
        $query = $this->db->query($sql, $idPlan);

        return $query;
    }

    /**
     * Finds and returns a list of successful plans by id_user
     * @access public
     * @param string $idUser Contains id_user
     * @description A function that executes a query with a SQL procedure 
     * 'viewSuccessPlan(id_user_param)'
     * @return array of success plans data values
     */
    public function success_plans_by_id($idUser)
    {
        $sql = 'CALL viewSuccessPlan(?)';
        $query = $this->db->query($sql, $idUser)->result_array();

        return $query;
    }
    
    /**
     * Finds and returns a list of failed plans by id_user
     * @access public
     * @param string $idUser Contains id_user
     * @description A function that executes a query with a SQL procedure 
     * 'viewFailPlan(id_user_param)'
     * @return array of failed plans data values
     */
    public function fail_plans_by_id($idUser)
    {
        $sql = 'CALL viewFailPlan(?)';
        $query = $this->db->query($sql, $idUser)->result_array();

        return $query;
    }

    /**
     * Finds and returns a list of user logs activity by id_user
     * @access public
     * @param string $idUser Contains id_user
     * @description A function that executes a query 
     * SELECT * FROM logs where id_user=$id ORDER BY times DESC
     * @return array of user logs data values
     */
    public function get_logs_by_id($idUser)
    {
        $this->db->order_by('times', 'DESC');
        $sql = $this->db->get_where('logs', ['id_user'=>$idUser]);
        $query = $sql->result_array();

        return $query;
    }
}