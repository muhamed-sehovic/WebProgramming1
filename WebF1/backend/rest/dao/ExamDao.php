<?php

class ExamDao {

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
          $port='';
          $dbname='';
          $host='';

          /** TODO
           * Create new connection
           */

          $this->conn=new PDO (
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
     * Implement DAO method used to get customer information
     */
    public function get_customers(){
      $sql="SELECT * FROM customers";
      $stmt=$this->conn->prepare($sql);
      $stmt->execute();
      $customers=$stmt->fetchAll(PDO::FETCH_ASSOC);
      return $customers; 
    }
    

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {
      $sql="SELECT
              foods.name AS food_name,
              foods.brand AS food_brand, 
              meals.created_at AS meal_date
            FROM meals 
            JOIN foods ON meals.food_id = foods.id
            WHERE meals.customer_id = :id";
      $stmt=$this->conn->prepare($sql);
      $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);
      $stmt->execute();
      $meals=$stmt->fetchAll(PDO::FETCH_ASSOC);
      return $meals;
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){
      $sql="INSERT INTO customers (first_name, last_name, birth_date, status) 
      VALUES (:first_name, :last_name, :birth_date, :status)";
      $stmt=$this->conn->prepare($sql);
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
      $sql = "SELECT 
            f.name,
            f.brand,
            CONCAT('<img src=\"', f.image, '\" width=\"100\"/>') AS image,
            SUM(CASE WHEN n.name = 'energy' THEN fn.amount ELSE 0 END) AS energy,
            SUM(CASE WHEN n.name = 'protein' THEN fn.amount ELSE 0 END) AS protein,
            SUM(CASE WHEN n.name = 'fat' THEN fn.amount ELSE 0 END) AS fat,
            SUM(CASE WHEN n.name = 'fiber' THEN fn.amount ELSE 0 END) AS fiber,
            SUM(CASE WHEN n.name = 'carbs' THEN fn.amount ELSE 0 END) AS carbs
          FROM foods f
          JOIN food_nutrients fn ON f.id = fn.food_id
          JOIN nutrients n ON fn.nutrient_id = n.id
          GROUP BY f.id
          LIMIT 100";

  $stmt = $this->conn->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}
?>
