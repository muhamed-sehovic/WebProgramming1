<?php

Flight::route('GET /connection-check', function(){
    /** TODO
    * This endpoint prints the message from constructor within ExamDao class
    * Goal is to check whether connection is successfully established or not
    * This endpoint does not have to return output in JSON format
    * 5 points
    */
    try {
        $examService = Flight::examService();
        echo "Database connection successful!";
    } catch (Exception $e) {
        echo "Database connection failed: " . $e->getMessage();
    }
});

Flight::route('GET /customers', function(){
    Flight::json(Flight::examService()->get_customers());
});

Flight::route('GET /customer/meals/@customer_id', function($customer_id){
    Flight::json(Flight::examService()->get_customer_meals($customer_id));
});

Flight::route('POST /customers/add', function() {
     $data = Flight::request()->data->getData();
    

     Flight::json(Flight::examService()->add_customer($data));
});

Flight::route('GET /foods/report', function(){
    Flight::json(Flight::examService()->get_foods_report());
});

?>
