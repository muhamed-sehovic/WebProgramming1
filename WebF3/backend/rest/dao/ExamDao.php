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
      $host='';
      $username='';
      $password='';
      $port='';
      $dbname='';

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
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public function login($data) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM users 
       WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':password', $data['password']);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }







  public function film_performance_report() {
    $stmt=$this->conn->prepare(
      "SELECT 
            c.category_id AS id, 
            c.name AS name, 
            COUNT(fc.film_id) AS total
      FROM category c
      JOIN film_category fc ON c.category_id=fc.category_id
      GROUP BY c.category_id, c.name");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }





  public function delete_film($film_id) {
    $stmt = $this -> conn -> prepare("DELETE FROM film WHERE film_id = :film_id");
    $stmt -> bindParam(':film_id', $film_id);
    return $stmt -> execute();
  }




public function edit_film($film_id, $data){
  $query = "UPDATE film SET title = :title, 
            description = :description, 
            release_year = :release_year 
            WHERE film_id = :film_id";
  $stmt = $this->conn->prepare($query);
  $stmt->execute(["title" => $data["title"],
                  "description" => $data["description"],
                  "release_year" => $data["release_year"],
                  "film_id" => $film_id
  ]);
  $stmt = $this->conn->prepare(
    "SELECT * FROM film 
    WHERE film_id = :film_id");
  $stmt->execute(["film_id" => $film_id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}








  public function get_customers_report() {
    $stmt = $this->conn->prepare(
      "SELECT 
            c.customer_id,
            CONCAT(c.first_name, ' ', c.last_name) AS customer_full_name,
            SUM(p.amount) AS total_amount
      FROM customer c
      JOIN payment p ON c.customer_id = p.customer_id
      GROUP BY c.customer_id, c.first_name, c.last_name
      ORDER BY total_amount DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }





  public function get_customer_rental_details($customer_id) {
    $stmt = $this->conn->prepare(
      "SELECT 
            r.rental_date,
            f.title AS film_title,
            p.amount AS payment_amount
        FROM rental r
        JOIN inventory i ON r.inventory_id = i.inventory_id
        JOIN film f ON i.film_id = f.film_id
        JOIN payment p ON r.rental_id = p.rental_id
        WHERE r.customer_id = :customer_id
        ORDER BY r.rental_date DESC");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }  
};
