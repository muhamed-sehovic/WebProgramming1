<?php

require "../vendor/autoload.php";
require "./services/ExamService.php";

Flight::register('examService', 'ExamService');

// Add CORS headers



require 'routes/ExamRoutes.php';

Flight::start();
?>
