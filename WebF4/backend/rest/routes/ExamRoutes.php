<?php

Flight::route('GET /employees/performance', function(){
    /** TODO
    * This endpoint returns performance report for every employee.
    * It should return array of all employees where every element
    * in array should have following properties
    *   `details` -> HTML code for edit and delete as shown in the frontend section
    *   `id` -> employeeNumber of the employee
    *   `full_name` -> concatenated firstName and lastName of the employee
    *   `total` -> total amount of money earned for every employee.
    *              aggregated amount from payments table for every employee
    * This endpoint should return output in JSON format
    * AND IT HAS TO BE FULLY SERVER SIDE PAGINATED
    * 10 points
    */
    Flight::json(Flight::examService() -> employees_performance_report());
});

Flight::route('DELETE /employee/delete/@employee_id', function($employee_id){
    /** TODO
    * This endpoint should delete the employee from database with provided id.
    * This endpoint should return output in JSON format that contains only 
    * `message` property that indicates that process went successfully.
    * YOU HAVE TO DELETE EMPLOYEE, IF IT DOES NOT DELETE THE EMPLOYEE FROM DB
    * YOU WILL NOT GET THE POINTS
    * 5 points
    */
    Flight::json(Flight::examService() -> delete_employee($employee_id));
});

Flight::route('PUT /employee/edit/@employee_id', function($employee_id) {
    /** TODO
    * This endpoint should save edited employee to the database.
    * The data that will come from the form (if you don't change
    * the template form) has following properties
    *   `first_name` -> first name of the employee
    *   `last_name` -> last name of the employee
    *   `email` -> email of the employee
    * This endpoint should return the edited customer in JSON format
    * 10 points
    */
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::examService() -> edit_employee($employee_id, $data));
});

Flight::route('GET /employee/@employee_id', function(){
    /** TODO
    * This endpoint should return all employee attributes by id in JSON format
    * 5 points
    */
    Flight::json(Flight::examService() -> get_employee($employee_id));
});

Flight::route('POST /employee/create', function(){
    /** TODO
    * This endpoint should create new employee in the database with 
    * following properties:
    *   `employeeNumber`
    *   `firstName`
    *   `lastName`
    *   `email`
    * This endpoint should return the newly created employee in JSON format
    * 10 points
    */
    $data = Flight::request() -> data -> getData();
    Flight::json(Flight::examService() -> create_employee($data));
});

?>
