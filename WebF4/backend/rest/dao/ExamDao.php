<?php

class ExamDao {

    /**
     * Host: db1.ibu.edu.ba
     * Database: samp_db
     * User: sampdb_usr
     * Password: samp997dbUSR
     */
    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
        try {
          /** TODO
           * List parameters such as servername, username, password, schema. Make sure to use appropriate port
           */
          $username='';
          $password='';
          $host='';
          $dbname='';
          $port='';

          /** TODO
           * Create new connection
           */
          $this -> conn = new PDO(
            "mysql:host=$host;port=$port;dbname=$dbname",
            $username,
            $password,
            [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
           );

          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
     * Implement DAO method used to get employees performance report
     */
    public function employees_performance_report(){
      $stmt = $this -> conn -> prepare(
        "SELECT e.employeeNumber AS id, 
                CONCAT(e.firstName, ' ', e.lastName) AS full_name, 
                e.email, SUM(p.amount) AS total
        FROM employees e
        JOIN customers c ON c.salesRepEmployeeNumber = e.employeeNumber
        JOIN payments p ON p.customerNumber = c.customerNumber
        GROUP BY e.employeeNumber");
      $stmt -> execute();
      return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
     * Implement DAO method used to delete employee by id
     */
    public function delete_employee($employee_id) {
      $stmt = $this -> conn -> prepare("DELETE FROM employees WHERE employeeNumber = :employee_id");
      $stmt -> bindParam(':employee_id', $employee_id);
      return $stmt -> execute();
    }

    /** TODO
     * Implement DAO method used to edit employee data
     */
    public function edit_employee($employee_id, $data){
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE employees SET $fields WHERE employeeNumber = :employee_id";
        $stmt = $this -> conn -> prepare($sql);
        $data['employee_id'] = $employee_id;
        return $stmt -> execute($data);
    }

    /** TODO
     * Implement DAO method used to get employee by id
     */
    public function get_employee($employee_id){
      $stmt=$this->conn->prepare
      ("SELECT * FROM employees WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return $stmt->fetch();
    }

    /** TODO
     * Implement DAO method used to create new employee
     */
    public function create_employee($data){
      $query = "INSERT INTO employees (employeeNumber, firstName, lastName, email) VALUES(:employeeNumber, :firstName, :lastName, :email)";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(["employeeNumber"=> $data["employeeNumber"],
                      "firstName" => $data["firstName"],
                      "lastName" => $data["lastName"],
                      "email" => $data["email"],
                      //"officeCode" => $data["officeCode"]

    ]);
    return $this->get_employee($data["employeeNumber"]);
    }
  };
?>
