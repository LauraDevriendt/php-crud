<?php


class OverviewController implements ControllerInterface
{
    public function render()
    {
        $manager = new DatabaseManager();


        if (isset($_POST['editTeacher'])) {
            try {
                $teacherEdit = $manager->loadTeacher((int)htmlspecialchars($_POST['teacherId']));
            } catch (TeacherException $e) {
                $e = "Teacher not found";
            }

        }

        if (isset($_POST['editingTeacher'])) {
            $manager->editTeacher((int)htmlspecialchars($_POST['teacherId']), htmlspecialchars($_POST['teacherName']), htmlspecialchars($_POST['teacherEmail']));

        }



        if (isset($_POST['editClass'])) {
            try {
                $editClass = $manager->loadClass((int)$_POST['classId']);
            } catch
            (ClassException $e) {
                $e = "Class not found";
            }

        }
        if (isset($_POST['editingClass'])) {
            $manager->editClass((int)htmlspecialchars($_POST['classId']), htmlspecialchars($_POST['className']), htmlspecialchars($_POST['campus']), (int)htmlspecialchars($_POST['teacherId']));

        }
        if (isset($_POST['editStudent'])) {
            try {
                $studentEdit = $manager->loadStudent((int)htmlspecialchars($_POST['editStudent']));
            } catch (StudentException $e) {
                $e = "Student not found";
            }

        }
        if (isset($_POST['editingStudent'])) {
            $manager->editStudent((int)htmlspecialchars($_POST['studentId']), htmlspecialchars($_POST['studentName']), htmlspecialchars($_POST['studentEmail']), (int)htmlspecialchars($_POST['classId']));

        }
        if (isset($_POST['deleteTeacher'])) {
            $teacher = $manager->findTeacherById((int)$_POST['deleteTeacher']);
            try {
                $manager->deleteTeacher($teacher);
            } catch (TeacherDeleteException $e) {
                $manager->setError($e->getMessage());
            }

        }

        if (isset($_POST['deleteClass'])) {
            try {
                $class = $manager->findClassById((int)$_POST['deleteClass']);
                $manager->deleteClass($class);
            } catch (ClassDeleteException $e) {
                $manager->setError($e->getMessage());
            }
        }

        if (isset($_POST['deleteStudent'])) {
            $student = $manager->findStudentById((int)$_POST['deleteStudent']);
            $manager->deleteStudent($student);

        }

        if(isset($_POST['deleteStudent'])|| isset($_POST['deleteTeacher'])||isset($_POST['deleteClass'])) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/php-crud/?error={$manager->getError()}");
            exit;
        }
        $teachers = $manager->getTeachers();
        $classes = $manager->getClasses();
        $students = $manager->getStudents();

        require 'View/overview.php';


    }



}