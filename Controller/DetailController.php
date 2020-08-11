<?php
class DetailController implements ControllerInterface {
    public function render(){
        $manager=new DatabaseManager();

        if($_GET['details']==='teacher') {
            $teacher = (new TeacherLoader())->findById((int)$_GET['id']);
        }
        if($_GET['details']==='class') {
            $class = (new ClassBecodeLoader())->findById((int)$_GET['id']);

        }
        if($_GET['details']==='student') {
            $student = (new StudentLoader())->findById((int)$_GET['id']);
        }

        if(isset($_POST['deleteStudent'])|| isset($_POST['deleteTeacher'])||isset($_POST['deleteClass'])) {
            (new OverviewController())->render();
        }

        require 'View/detailedView.php';

    }
}