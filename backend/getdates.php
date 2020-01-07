<?php

require('DateArray.php');

$baseline = $_POST['baseline'];
$total = $_POST['total'];
$start_date = $_POST['sDate'];
$end_date = $_POST['eDate'];

$dateCalc = new DateArray($baseline, $total, $start_date, $end_date);

try {
    $arrayFilled = $dateCalc->getDateArray();

    if (!$arrayFilled) {
        echo "There was an error, please check your input data, make sure the dates are correct";
        return false;
    }
    
    echo '<pre>';
    print_r($dateCalc->getDateArray());
} catch (Exception $err) {
    echo "There was an error, please check your input data, make sure the dates are correct";
}
