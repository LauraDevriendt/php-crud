<?php


class DetailedOverviewController implements ControllerInterface
{
    public function render(){
        $manager = new DatabaseManager();
        $teachers = $manager->getTeachers();
        $classes = $manager->getClasses();
        $students = $manager->getStudents();

        require 'View/detailedOverview.php';

    }

}