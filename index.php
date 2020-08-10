<?php
declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);

require 'resources/secret.php';
require 'Controller/ControllerCreate.php';
require 'Model/DatabaseManager.php';

require 'Model/Teacher.php';
require 'Model/ClassBecode.php';
require 'Model/Student.php';

// $createController=(new ControllerCreate())->render();

$manager = new DatabaseManager();
$teachers = $manager->getTeachers();
$classes = $manager->getClasses();
$students = $manager->getStudents();

if (isset($_POST['deleteTeacher'])) {
    /*
    $handle=$manager->getDbcontroller()->prepare('DELETE FROM teacher WHERE teacher_id = :id');
    $handle->bindValue(':id', (int) htmlspecialchars($_POST['deleteTeacher']));
    $handle->execute();
    */
}

if (isset($_POST['editTeacher'])) {
    try {
        $teacherEdit = $manager->loadTeacher((int)htmlspecialchars($_POST['teacherId']));
        var_dump($teacherEdit);
    } catch (TeacherException $e) {
        $e = "Teacher not found";
    }


}
$teachers = $manager->getTeachers();
var_dump($teachers);
require 'View/overview.php';
