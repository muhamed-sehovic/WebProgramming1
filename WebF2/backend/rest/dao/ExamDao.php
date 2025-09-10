<?php

class ExamDao
{

  private $conn;

  /**
   * constructor of dao class
   */
  public function __construct()
  {
    try {
      /** TODO
       * List parameters such as servername, username, password, schema. Make sure to use appropriate port
       */
      $host='db1.ibu.edu.ba';
      $port='3306';
      $dbname='webfinal_db_3006';
      $username='webfinal_db_user2';
      $password='webFinal3006';
      
      /** TODO
       * Create new connection
       */
      $this->conn=new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password,
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
        );

      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connemployees_performance_reportection failed: " . $e->getMessage();
    }
  }

  /** TODO
   * Implement DAO method used to get employees performance report
   */
  public function employees_performance_report() {
    $stmt=$this->conn->prepare(
      "SELECT 
          e.employeeNumber AS id, 
          CONCAT(e.firstName, ' ', e.lastName) AS full_name,
          e.email AS email, 
          SUM(p.amount) AS total
          FROM employees e
          JOIN customers c ON c.salesRepEmployeeNumber = e.employeeNumber
          JOIN payments p ON p.customerNumber = c.customerNumber
          GROUP BY e.employeeNumber");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}


  /** TODO
   * Implement DAO method used to delete employee by id
   */
  public function delete_employee($employee_id) {
    $stmt=$this->conn->prepare(
      "DELETE FROM employees WHERE employeeNumber = :employee_id");
      $stmt->bindParam(':employee_id', $employee_id);
      return $stmt->execute();

}


  /** TODO
   * Implement DAO method used to edit employee data
   */
    public function edit_employee($employee_id, $data) {
      $fields="";
      foreach($data as $key => $value){
        $fields .= "$key = :$key";
      }

      $fields=rtrim($fields, ", ");
      $sql="UPDATE employees SET $fields WHERE employeeNumber = :employee_id";
      $stmt=$this->conn->prepare($sql);
      $data['employee_id']=$employee_id;
      return $stmt->execute($data);
  }
  

  /** TODO
   * Implement DAO method used to get orders report
   */
  public function get_orders_report() {
    $stmt=$this->conn->prepare(
      "SELECT o.orderNumber AS order_number,
              SUM(od.quantityOrdered*od.priceEach) AS total_amount
      FROM orders o
      JOIN orderdetails od ON o.orderNumber=od.orderNumber
      GROUP BY order_number");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


  /** TODO
   * Implement DAO method used to get all products in a single order
   */
  public function get_order_details($order_id) {
    $stmt=$this->conn->prepare(
      "SELECT p.productName AS product_name,
              od.quantityOrdered AS quantity, 
              od.priceEach AS price_each
      FROM products p
      JOIN orderdetails od ON od.productCode = p.productCode
      WHERE od.orderNumber = :order_id");
      $stmt->bindParam(':order_id', $order_id);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);    
}
};