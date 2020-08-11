<?php
class DetailController implements ControllerInterface {
    public function render(){
        $manager=new DatabaseManager();

        if($_GET['details']==='teacher') {
            $teacher = $manager->findTeacherById((int)$_GET['id']);
        }
        if($_GET['details']==='class') {
            $class = $manager->findClassById((int)$_GET['id']);
        }
        if($_GET['details']==='student') {
            $student = $manager->findStudentById((int)$_GET['id']);
        }


        require 'View/detailedView.php';

    }
}