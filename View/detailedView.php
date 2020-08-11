<?php require 'includes/header.php' ?>
<section class="container">
    <h1>Detailed Overview</h1>
    <?php if (isset($error)) {
        echo "<div class='alert alert-danger' role='alert'><strong>Oh snap!</strong> {$error}</div>";
    } ?>
    <?php if(isset($teacher)):?>
        <h2>Teacher: <?php echo "{$teacher->getName()}"?> </h2>
       <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteTeacher' value="<?php echo "{$teacher->getId()}";?>">Delete teacher</button>
           </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>email</th>
                <th>Students</th>
            </tr>
            </thead>
            <tbody>
        <tr>
            <td><?php echo "{$teacher->getName()}"?></td>
            <td><?php echo "{$teacher->getEmail()}"?></td>
            <td>
            <?php
            $loader=new TeacherLoader();
            echo "{$loader->createStudentTeacherList($teacher->getId())}"
            ?>
            </td>
        </tr>
            </tbody>
        </table>
    <?php endif;?>
    <?php if(isset($class)):?>
        <h2>Class: <?php echo"{$class->getName()}"?></h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteClass' value="<?php echo "{$class->getId()}";?>">Delete class</button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>campus</th>
                <th>Teacher</th>
                <th>Students</th>
            </tr>
            </thead>
            <tbody>

        <tr>
            <td><?php echo "{$class->getName()}"?></td>
            <td><?php echo "{$class->getCampus()}"?></td>
            <td><a href="<?php echo "?details=teacher&id={$class->getTeacher()->getId()}"?>"><?php echo"{$class->getTeacher()->getName()}"?></a></td>
            <td>
           <?php
           $loader=new ClassBecodeLoader();
           echo"{$loader->createStudentClassList($class->getId())}"?>
            </td>
        </tr>
            </tbody>
        </table>
    <?php endif;?>
    <?php if(isset($student)):?>
        <h2>Students</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-danger' type='submit' name='deleteStudent' value="<?php echo "{$student->getId()}";?>">Delete student</button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>Teacher</th>
            </tr>
            </thead>
            <tbody>

        <tr>
            <td><?php echo"{$student->getName()}"?></td>
            <td><?php echo"{$student->getEmail()}"?></td>
            <td><a href="<?php echo "?details=class&id={$student->getClass()->getId()}"?>"class='btn btn-secondary'> <?php echo"{$student->getClass()->getName()}"?></a></td>
            <td><a href="<?php echo "?details=teacher&id={$student->getClass()->getTeacher()->getId()}"?>"class='btn btn-secondary' ><?php echo"{$student->getClass()->getTeacher()->getName()}"?></a></td>
           
        </tr>
            </tbody>
        </table>
    <?php endif;?>
</section>


<?php require 'includes/footer.php' ?>

