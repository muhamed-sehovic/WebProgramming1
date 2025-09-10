<?php
require_once __DIR__ . "/../dao/ExamDao.php";

class ExamService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new ExamDao();
    }

    public function login($data) {
        $user = $this->dao->login($data);
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid email or password'
            ];
        }

        $payload = [
            'iss' => 'yourdomain.com',
            'iat' => time(),
            'exp' => time() + 3600, 
            'user_id' => $user['id'],
            'email' => $user['email']
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        unset($user['password']);

        return [
            'success' => true,
            'message' => 'User logged in successfully',
            'token' => $jwt,
            'user' => $user
        ];
    }

    public function film_performance_report() {
        return $this->dao->film_performance_report();
    }

    public function delete_film($film_id) {
        return $this->dao->delete_film($film_id);
    }

    public function edit_film($film_id, $data) {
        return $this->dao->edit_film($film_id, $data);
    }

    public function get_customers_report() {
        return $this->dao->get_customers_report();
    }

    public function get_customer_rental_details($customer_id) {
        return $this->dao->get_customer_rental_details($customer_id);
    }
}
