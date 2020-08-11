<?php


class ControllerEdit implements ControllerInterface
{
public function render(){
    $manager=new DatabaseManager();
    $teachers = $manager->getTeachers();
    $classes = $manager->getClasses();
    $students = $manager->getStudents();

    if ($_GET['edit']==='teacher') {
        try {
            $teacherEdit = (new TeacherLoader())->load((int)$_GET['id']);
        } catch (TeacherException $e) {
            $manager->setError("Teacher not found");
        }

    }
    if (isset($_POST['editingTeacher'])) {
        (new TeacherLoader())->edit((int)htmlspecialchars($_POST['teacherId']), htmlspecialchars($_POST['teacherName']), htmlspecialchars($_POST['teacherEmail']));
    }
    if ($_GET['edit']==='class') {
        try {
            $editClass = (new ClassBecodeLoader())->load((int)$_GET['id']);
        } catch
        (ClassException $e) {
            $manager->setError("Class not found");
        }

    }
    if (isset($_POST['editingClass'])) {
        (new ClassBecodeLoader())->edit((int)htmlspecialchars($_POST['classId']), htmlspecialchars($_POST['className']), htmlspecialchars($_POST['campus']), (int)htmlspecialchars($_POST['teacherId']));

    }
    if ($_GET['edit']==='student') {
        try {
            $studentEdit = (new StudentLoader())->load((int)$_GET['id']);
        } catch (StudentException $e) {
            $manager->setError("Student not found");
        }

    }
    if (isset($_POST['editingStudent'])) {
        (new StudentLoader())->edit((int)htmlspecialchars($_POST['studentId']), htmlspecialchars($_POST['studentName']), htmlspecialchars($_POST['studentEmail']), (int)htmlspecialchars($_POST['classId']));

    }
    if(isset($_POST['editingTeacher'])|| isset($_POST['editingClass'])||isset($_POST['editingStudent'])) {
        header("Location: http://{$_SERVER['HTTP_HOST']}/php-crud/?error={$manager->getError()}");
        exit;
    }
require 'View/edit.php';
}
}