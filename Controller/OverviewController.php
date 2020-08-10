<?php


class OverviewController implements ControllerInterface
{
public function render(){
    $manager = new DatabaseManager();
    $teachers = $manager->getTeachers();
    $classes = $manager->getClasses();
    $students = $manager->getStudents();

    if (isset($_POST['editTeacher'])) {
        try {
            $teacherEdit = $manager->loadTeacher((int)htmlspecialchars($_POST['teacherId']));
        } catch (TeacherException $e) {
            $e = "Teacher not found";
        }

    }
    if(isset($_POST['editingTeacher'])){
        $manager->editTeacher((int) htmlspecialchars($_POST['teacherId']), htmlspecialchars($_POST['teacherName']), htmlspecialchars($_POST['teacherEmail']));
        $teachers = $manager->getTeachers();
    }
    if (isset($_POST['editClass'])) {
        try {
            $editClass = $manager->loadClass((int)htmlspecialchars($_POST['classId']));
        } catch (ClassException $e) {
            $e = "Class not found";
        }

    }
    if(isset($_POST['editingClass'])){
        $manager->editClass((int) htmlspecialchars($_POST['classId']), htmlspecialchars($_POST['className']), htmlspecialchars($_POST['campus']),(int)htmlspecialchars($_POST['teacherId']));
        $classes = $manager->getClasses();

    }
    if (isset($_POST['editStudent'])) {
        try {
            $studentEdit = $manager->loadStudent((int)htmlspecialchars($_POST['studentId']));
        } catch (StudentException $e) {
            $e = "Student not found";
        }

    }
    if(isset($_POST['editingStudent'])){
        $manager->editStudent((int) htmlspecialchars($_POST['studentId']), htmlspecialchars($_POST['studentName']), htmlspecialchars($_POST['studentEmail']), (int)htmlspecialchars($_POST['classId']));
        $students = $manager->getStudents();
    }


    require 'View/overview.php';

}
}