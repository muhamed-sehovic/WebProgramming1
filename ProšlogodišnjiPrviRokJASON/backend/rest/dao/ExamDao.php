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

          $username = "root";
          $password = "";
          $dsn = "mysql:host=localhost;dbname=webfinal;charset=utf8;";

          /** TODO
           * Create new connection
           */

          $this->conn = new PDO($dsn, $username, $password);

          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    /** TODO
     * Implement DAO method used to get customer information
     */



    public function query($sql, $params=[]){

        $result = $this->conn->prepare($sql);
        $result->execute($params);

        return $result;

    }


    public function get_customers(){

        $query = "SELECT * FROM customers";
        return $this->query($query)->fetchAll(PDO::FETCH_ASSOC);

    }

    /** TODO
     * Implement DAO method used to get customer meals
     */
    public function get_customer_meals($customer_id) {

        $query = "SELECT foods.name AS food_name, foods.brand as foods_brand, meals.created_at AS meal_date FROM meals INNER JOIN foods ON meals.food_id = foods.id WHERE customer_id= :id GROUP BY name, brand, created_at";
        return $this->query($query, ['id' => $customer_id])->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
     * Implement DAO method used to save customer data
     */
    public function add_customer($data){


      $query = "INSERT INTO customers (first_name, last_name, birth_date) VALUES (:fname, :lname, :bdate)";
      $this->query($query, ['fname' => $data['first_name'],
                                         'lname' => $data['last_name'],
                                         'bdate' => $data['birth_date'],
                                        ]);

        return $this->conn->lastInsertId();
    }

    /** TODO
     * Implement DAO method used to get foods report
     */
    public function get_foods_report(){

        $query = "SELECT foods.name as name, foods.image_url as image, foods.brand as brand FROM foods 
                  INNER JOIN food_nutrients ON foods.id = food_nutrients.food_id
                  INNER JOIN nutrients ON food_nutrients.nutrient_id = nutrients.id
                  GROUP BY foods.id, foods.name";

        return $this->query($query)->fetchAll(PDO::FETCH_ASSOC);


    }


    
}
?>
