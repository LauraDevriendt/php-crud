<?php


class OverviewController implements ControllerInterface
{
    public function render()
    {
        $manager = new DatabaseManager();
        if (isset($_POST['deleteTeacher'])) {
            $teacher = (new TeacherLoader())->findById((int)$_POST['deleteTeacher']);
            try {
                (new TeacherLoader())->delete($teacher);
            } catch (TeacherDeleteException $e) {
                $manager->setError($e->getMessage());
            }

        }
        if (isset($_POST['deleteClass'])) {
            try {
                $class = (new ClassBecodeLoader())->findById((int)$_POST['deleteClass']);
                (new ClassBecodeLoader())->delete($class);
            } catch (ClassDeleteException $e) {
                $manager->setError($e->getMessage());
            }
        }
        if (isset($_POST['deleteStudent'])) {
            $student = (new StudentLoader())->findById((int)$_POST['deleteStudent']);
            (new StudentLoader())->delete($student);

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