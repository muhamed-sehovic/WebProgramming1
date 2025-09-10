<?php
require_once __DIR__."/../dao/ExamDao.php";

class ExamService {
    protected $dao;

    public function __construct(){
        $this->dao = new ExamDao();
    }

    /** TODO
    * Implement service method used to get employees performance report
    */
    public function employees_performance_report(){
        return $this->dao->employees_performance_report();
    }

    /** TODO
    * Implement service method used to delete employee by id
    */
    public function delete_employee($employee_id){
        $success = $this->examDao->delete_employee($employee_id);

        if ($success) {
          return ["message" => "Employee successfully deleted."];
        } else {
          return ["message" => "Failed to delete employee."];
        }
    }

    /** TODO
    * Implement service method used to edit employee data
    */
    public function edit_employee($employee_id, $data){
        return $this->dao->edit_employee($employee_id, $data);

    }

    /** TODO
    * Implement service method used to get orders report
    */
    public function get_employee($employee_id){
        return $this->dao->get_employee($employee_id);

    }

    /** TODO
    * Implement service method used to create new employee
    */
    public function create_employee($data){
        return $this->dao->create_employee($data);
    }
}