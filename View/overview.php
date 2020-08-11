<?php require 'includes/header.php' ?>
<section class="container">
    <?php if (empty($teacherEdit) && empty($editClass) && empty($studentEdit)): ?>
        <h1>Overview</h1>
        <?php if (!empty($_GET['error'])) {
            echo "<div class='alert alert-danger' role='alert'><strong>Oh snap!</strong> {$_GET['error']}</div>";
        } ?>
        <h2>Teachers</h2>
            <a href="?create=teacher" class='mb-1 btn btn-success' type='submit'>New Teacher</a>
    <?php if(!empty($teachers)) :?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Modification</th>
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
            <td><a href='?details=teacher&id={$teacher->getId()}' class='btn btn-secondary'>{$teacher->getName()}</a></td>
            <td class='d-flex'>
            <form method='post' action=''>
            <button  class='btn btn-danger mr-1' type='submit' name='deleteTeacher' value='{$teacher->getId()}'>Delete</button>
            <input type='hidden' name='teacherId' value='{$teacher->getId()}'>
            </form>
             <a href='?edit=teacher&id={$teacher->getId()}' class='btn btn-info'>Edit</a>
            </td>
        </tr>";
            }
            ?>
            </tbody>
        </table>
    <?php endif;?>
    <?php endif; ?>
    <?php if (empty($teacherEdit) && empty($editClass) && empty($studentEdit) &&!empty($teachers)): ?>
        <h2>Classes</h2>
        <a href='?create=class' class='mb-1 btn btn-success' type='submit'>New Class</a>
      <?php if (!empty($classes)) :?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Modification</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /**
             * @var ClassBecode[] $classes
             */
            foreach ($classes as $key => $class) {
                $key += 1;
                echo "
        <tr>
            <th scope='row'>$key</th>
            <td><a class='btn btn-secondary'  href='?details=class&id={$class->getId()}'>{$class->getName()}</a></td>
            <td class='d-flex'><form method='post'>
                        <input type='hidden' name='classId' value='{$class->getId()}'>
            <button  class='mr-1 btn btn-danger' type='submit' name='deleteClass'  value='{$class->getId()}'>Delete</button>
</form>
             <a href='?edit=class&id={$class->getId()}' class='btn btn-info'>Edit</a>

</td>
        </tr>";
            }
            ?>
            </tbody>
        </table>
       <?php endif ?>
    <?php endif; ?>
    <?php if (empty($teacherEdit) && empty($editClass) && empty($studentEdit) &&!empty($classes)): ?>
        <h2>Students</h2>
            <a href='?create=student' class='mb-1 btn btn-success' type='submit'>New Student</a>
     <?php if (!empty($students)) :?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Modification</th>
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
            <td><a class='btn btn-secondary'  href='?details=student&id={$student->getId()}'>{$student->getName()}</a></td>
            <td class='d-flex'><form method='post'>
            <button  class='mr-1 btn btn-danger' type='submit' name='deleteStudent' value='{$student->getId()}' >Delete</button>            
            </form>
             <a href='?edit=student&id={$student->getId()}' class='btn btn-info'>Edit</a>
</td>
        </tr>";
            }
            ?>
            </tbody>
        </table>
     <?php endif ?>
    <?php endif; ?>
</section>


<?php require 'includes/footer.php' ?>
