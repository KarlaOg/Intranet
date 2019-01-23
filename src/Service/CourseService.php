<?php

namespace App\Service;

use App\Entity\Courses;
use App\Entity\User;
use App\Repository\CoursesRepository;

class CourseService
{
    public function removeTeacherAsStudent(object $data, array $students)
    {
        foreach($data as $key => $value){
            $students[$value->getId()] = $value->getUsers();
        }
        return $students;
    }

    public function getUserByCourse($id, array $user, CoursesRepository $coursesRepository)
    {
        $course = $coursesRepository->find($id);
        $users = [];
        foreach ($course->getUsers() as $value) {
            $users[] = $value->getUsername();
        }
        return $users;
    }
}