<?php
class ControllerCreate implements ControllerInterface {
    public function render(){
        $manager = new DatabaseManager();
        $teachers = $manager->getTeachers();
        $classes = $manager->getClasses();
        $students = $manager->getStudents();


        if(isset($_POST['createTeacher'])){
            $manager->createTeacher(htmlspecialchars($_POST['teacherName']),htmlspecialchars($_POST['teacherEmail']));
        }

        if(isset($_POST['createClass'])){
            $manager->createClass(htmlspecialchars($_POST['className']),htmlspecialchars($_POST['campus']),(int)htmlspecialchars($_POST['teacher']));
        }

        if(isset($_POST['createStudent'])){
            $manager->createStudent(htmlspecialchars($_POST['studentName']),htmlspecialchars($_POST['email']),(int)htmlspecialchars($_POST['class']));
        }



        require 'View/create.php';
    }
}