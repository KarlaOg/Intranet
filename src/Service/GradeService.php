<?php

namespace App\Service;

class GradeService 
{
    public function countAverage(array $data)
    {
        if (count($data) === 0) {
            $average = "No average has been recorded";
            return $average;
        } else {
            $sum = array_reduce($data, function($carry, $item) {
                $carry += $item->getGrade();
                return $carry;
            }, 0);
            $average = "Your average grade is : ".$sum/count($data);
            return $average;
        }
    }
}