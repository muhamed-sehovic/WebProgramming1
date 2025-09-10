<?php

require_once 'ExamDao.php';

$test = new ExamDao();

print_r(
    $test->get_foods_report()
);