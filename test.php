<?php 
include_once("./function.php");

$test = new BayesianMonthlyListenersEstimator();

var_dump(json_encode($test->estimateAverageMonthlyListeners()));
?>