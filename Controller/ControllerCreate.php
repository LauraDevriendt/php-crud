<?php
class ControllerCreate implements ControllerInterface {
    public function render(){
        $manager = new DatabaseManager();
        $teachers = $manager->getTeachers();
        $classes = $manager->getClasses();
        $students = $manager->getStudents();

        if(isset($_POST['createTeacher'])){
            try {
                (new TeacherLoader())->create(htmlspecialchars($_POST['teacherName']), htmlspecialchars($_POST['teacherEmail']));
                $manager->setMessage('succesfully created');
            } catch (TeacherCreateException $e) {
                $manager->setError($e->getMessage());
            }
        }

        if(isset($_POST['createClass'])){
            try {
                (new ClassBecodeLoader())->create(htmlspecialchars($_POST['className']),htmlspecialchars($_POST['campus']),(int)htmlspecialchars($_POST['teacher']));
                $manager->setMessage('succesfully created');
            } catch (ClassCreateException $e) {
                $manager->setError($e->getMessage());
            }
        }

        if(isset($_POST['createStudent'])){
            try {
                (new StudentLoader())->create(htmlspecialchars($_POST['studentName']),htmlspecialchars($_POST['email']),(int)htmlspecialchars($_POST['class']));
                $manager->setMessage('succesfully created');
            } catch (StudentCreateException $e) {
                $manager->setError($e->getMessage());
            }
        }





        require 'View/create.php';

    }
}