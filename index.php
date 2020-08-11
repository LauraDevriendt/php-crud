<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

require 'resources/secret.php';
require 'Controller/ControllerInterface.php';
require 'Controller/ControllerCreate.php';
require 'Controller/OverviewController.php';
require 'Controller/DetailedOverviewController.php';
require 'Model/DatabaseManager.php';

require 'Model/Teacher.php';
require 'Model/ClassBecode.php';
require 'Model/Student.php';

//


if (isset($_POST['createStudent']) || isset($_POST['createTeacher']) || isset($_POST['createClass']) ||isset($_POST['creationStudent']) || isset($_POST['creationTeacher']) || isset($_POST['creationClass'])) {
    $controller=new ControllerCreate();
    /*
    $handle=$manager->getDbcontroller()->prepare('DELETE FROM teacher WHERE teacher_id = :id');
    $handle->bindValue(':id', (int) htmlspecialchars($_POST['deleteTeacher']));
    $handle->execute();
    */
}elseif (isset($_POST['detailedOverviewTeacher']) || isset($_POST['detailedOverviewClass'])|| isset($_POST['detailedOverviewStudent'])){
    $controller= new DetailedOverviewController();
}else{
    $controller= new OverviewController();
}
$controller->render();
