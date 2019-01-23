<?php

use App\Entity\Courses;
use App\Entity\User;
namespace App\Service;

class CourseService
{
    public function removeTeacherAsStudent(object $data, array $students)
    {
        foreach($data as $key => $value){
            return $students[$value->getId()] = $value->getUsers();
        }
    }
}