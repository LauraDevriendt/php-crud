<?php
class ControllerCreate implements ControllerInterface {
    public function render(){
        $manager = new DatabaseManager();
        $teachers = $manager->getTeachers();
        $classes = $manager->getClasses();
        $students = $manager->getStudents();

        if(isset($_POST['creationStudent']) || isset($_POST['creationTeacher']) || isset($_POST['creationClass'])){
            require 'View/create.php';
        }


        if(isset($_POST['createTeacher'])){
            $manager->createTeacher(htmlspecialchars($_POST['teacherName']),htmlspecialchars($_POST['teacherEmail']));
            (new OverviewController())->render();

        }

        if(isset($_POST['createClass'])){
            $manager->createClass(htmlspecialchars($_POST['className']),htmlspecialchars($_POST['campus']),(int)htmlspecialchars($_POST['teacher']));
            (new OverviewController())->render();
        }

        if(isset($_POST['createStudent'])){
            $manager->createStudent(htmlspecialchars($_POST['studentName']),htmlspecialchars($_POST['email']),(int)htmlspecialchars($_POST['class']));
            (new OverviewController())->render();
        }




    }
}