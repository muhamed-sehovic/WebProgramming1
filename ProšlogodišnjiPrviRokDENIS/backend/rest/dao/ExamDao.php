<?php

require_once 'Database.php';

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
      $this->conn = Database::connect();
    }

    /** TODO
     * Implement DAO method used to get customer information
     */
    public function get_customers(){
      $sql = 'SELECT * FROM customers';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $customers;

    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {
      $sql = 'SELECT c.*, m.*, f.* FROM customers c JOIN meals m on c.id = m.customer_id JOIN foods f on m.food_id = f.id WHERE c.id = :customer_id';
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
      $stmt->execute();
      $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $meals;
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){
      $sql = 'INSERT INTO customers (first_name, last_name, birth_date, status) VALUES (:first_name, :last_name, :birth_date, :status)';
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':first_name', $data['first_name']);
      $stmt->bindParam(':last_name', $data['last_name']);
      $stmt->bindParam(':birth_date', $data['birth_date']);
      $stmt->bindParam(':status', $data['status']);
      $stmt->execute();
      return $this->conn->lastInsertId();
    }

    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){
      $sql = 'SELECT * FROM foods f JOIN food_nutrients fn ON f.id = fn.food_id JOIN nutrients n ON fn.nutrient_id = n.id LIMIT 1000';
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $foods_report = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $foods_report;
    }
}
?>
