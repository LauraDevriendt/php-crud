<?php require 'includes/header.php' ?>
<section class="container">
    <h1>Detailed Overview</h1>
    <?php if(isset($_POST['detailedOverviewTeacher'])):?>
        <h2>Teachers</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteTeachers'>Delete all teachers</button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>email</th>
                <th>Students</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /**
             * @var Teacher[] $teachers
             */
            foreach ($teachers as $key => $teacher) {
                $key += 1;
                echo "
        <tr>
            <th scope='row'>$key</th>
            <td>{$teacher->getName()}</td>
            <td>{$teacher->getEmail()}</td>
            <td>
           {$manager->createStudentTeacherList($teacher->getId())}
            </td>
        </tr>";
            }
            ?>
            </tbody>
        </table>
    <?php endif;?>
    <?php if((isset($_POST['detailedOverviewClass']))):?>
        <h2>Classes</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteClasses'>Delete all classes</button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>campus</th>
                <th>Teacher</th>
                <th>Students</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /**
             * @var classBecode[] $classes
             */
            foreach ($classes as $key => $class) {
                $key += 1;
                echo "
        <tr>
            <th scope='row'>$key</th>
            <td>{$class->getName()}</td>
            <td>{$class->getCampus()}</td>
            <td><button name='teacherClass' class='btn btn-secondary' type='submit' value='{$class->getTeacher()->getId()}'>{$class->getTeacher()->getName()}</button></td>
            <td>
           {$manager->createStudentClassList($class->getId())}
            </td>
        </tr>";
            }
            ?>
            </tbody>
        </table>
    <?php endif;?>
    <?php if((isset($_POST['detailedOverviewStudent']))):?>
        <h2>Students</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteStudents'>Delete all students</button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Teacher</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /**
             * @var Student[] $students
             */
            foreach ($students as $key => $student) {
                $order = $key + 1;
                echo "
        <tr>
            <th scope='row'>$order</th>
            <td>{$student->getName()}</td>
            <td>{$student->getEmail()}</td>
            <td><button name='studentClass'type='submit' class='btn btn-secondary' value='{$student->getClass()->getId()}'> {$student->getClass()->getName()}</button></td>
            <td><button name='studentTeacher' type='submit' class='btn btn-secondary' value='{$student->getClass()->getTeacher()->getId()}'>{$student->getClass()->getTeacher()->getName()}</button> </td>
           
        </tr>";
            }
            ?>
            </tbody>
        </table>
    <?php endif;?>
</section>


<?php require 'includes/footer.php' ?>
