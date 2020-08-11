<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

require 'resources/secret.php';
require 'Controller/ControllerInterface.php';
require 'Controller/ControllerCreate.php';
require 'Controller/OverviewController.php';
require 'Controller/DetailController.php';

require 'Model/DatabaseManager.php';
require 'Model/TeacherLoader.php';
require 'Model/ClassBecodeLoader.php';
require 'Model/StudentLoader.php';
require 'Model/Teacher.php';
require 'Model/ClassBecode.php';
require 'Model/Student.php';

//


if (isset($_GET['create'])) {
    $controller=new ControllerCreate();

}  elseif(isset($_GET['details']) &&!isset($_POST['deleteTeacher']) &&!isset($_POST['deleteStudent'])&&!isset($_POST['deleteClass'])) {
    $controller = new DetailController();
}
else {
    $controller = new OverviewController();
}
$controller->render();


