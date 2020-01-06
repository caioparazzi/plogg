<?php

require('DateArray.php');

$baseline=50;

$total=100;

$start_date='2016-12-19';

$end_date='2016-12-24';

$dateCalc = new DateArray($baseline, $total, $start_date, $end_date);

print_r($dateCalc->getDateArray());