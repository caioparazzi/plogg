<?php

class DateArray
{

    private $baseline;
    private $total;
    private $start_date;
    private $end_date;
    private $limitUp;
    private $limitDown;

    function __construct($baseline, $total, $start_date, $end_date) {
        $this->baseline = $baseline;
        $this->total = $total;
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $this->limitUp = ($total*101)/100;
        $this->limitDown = ($total*99)/100;
    }

    private function populateArray()
    {
        $baseline = $this->baseline;
        $total = $this->total;

        $begin = new DateTime($this->start_date);
        $end = new DateTime($this->end_date);
        $end = $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        if ($begin > $end) {
            return false;
        }

        $totalValue = $total;

        $result = array();
        $weekdays = 0;

        foreach ($daterange as $date) {
            if ($date->format("N") < 6) $weekdays++;
        }

        $valueMin = (($total * $baseline) / 100) / $weekdays;
        $count = 0;
        $randomValue = 100;

        foreach ($daterange as $date) {
            if ($date->format("N") >= 6) {
                $result[$date->format("Y-m-d")] = 0.00;
            } 
            else {
                $valueMaxTest = $totalValue - ($valueMin * $weekdays);
                
                if ($valueMaxTest > 0) {
                    if ($total > $valueMin) {
                        $randomValue = (float) mt_rand($valueMin * 10, ($total) * 10) / 10;
                    }
                    else {
                        $randomValue = (float) $valueMin + $total;
                    }
                }
                else {
                    $randomValue = (float) $valueMin;
                }

                $result[$date->format("Y-m-d")] = $randomValue;
                $total = $total - $randomValue;
                $count++;
            }
        }

        return $result;
    }


    public function getDateArray()
    {
        try {
            $sum = 0;

            while (!($sum > $this->limitDown && $sum < $this->limitUp)) {
                unset($validArray);
                $sum = 0;
                $individualValue = 0;
                $validArray = $this->populateArray();
                
                if (!$validArray) {
                    return "Please check your parameters";
                }
                
                foreach ($validArray as $individualValue) {
                    $sum = $sum + $individualValue;
                }
            }
            return $validArray;
        } catch (Exception $error) {
            return false;
        }
    }
}
