<?php require 'includes/header.php'?>
<section class="container">
    <?php if(!empty($manager->getError())) {
   echo  "{$manager->getError()}";
    }?>

    <h1>Creation Becode</h1>
    <div class="row">
        <?php if(isset($_POST['creationTeacher']) ):?>
        <section class="col-12 container my-2">
            <h5>Create a Teacher</h5>
            <form method="post">
                <div class="form-group">
                    <label for="teacherName">Name:</label>
                    <input name="teacherName" type="text" class="form-control" id="teacherName" placeholder="Type here ..." required>
                </div>
                <div class="form-group">
                    <label for="teacherEmail">Email: </label>
                    <input name="teacherEmail" type="teacherEmail" class="form-control" id="teacherEmail" placeholder="Type here ..." required>
                </div>
                <button name="createTeacher" type="submit">Submit</button>
            </form>
        </section>
        <?php endif;?>


        <?php if(!empty($teachers) &&isset($_POST['creationClass'])) :?>
            <section class="col-12 container my-2">
                <h5>Create a Class</h5>
                <form method="post">
                    <div class="form-group">
                        <label for="className">Name:</label>
                        <input name="className" type="text" class="form-control" id="className" placeholder="Type here ..." required>
                    </div>
                    <div class="form-group">
                        <label for="campus">Campus:</label>
                        <select name="campus" id="campus">
                            <option value="Antwerp">Antwerp</option>
                            <option value="Gent">Gent</option>
                            <option value="Brussel">Brussel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher">Teacher:</label>
                        <select name="teacher" id="teacher">
                           <?php
                           foreach ($teachers as $teacher){
                               echo "<option value='{$teacher->getId()}'>{$teacher->getName()}</option>";
                           }
                           ?>
                        </select>
                    </div>
                    <button name="createClass" type="submit">Submit</button>
                </form>
            </section>
        <?php endif ?>
        <?php if(!empty($teachers) && !empty($classes) &&(isset($_POST['creationStudent']))) :?>
        <section class="col-12 container my-2">
            <h5>Create a Student</h5>
            <form method="post">
                <div class="form-group">
                    <label for="studentName">Name:</label>
                    <input name="studentName" type="text" class="form-control" id="studentName" placeholder="Type here ..." required>
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Type here ..." required>
                </div>
                <div class="form-group">
                    <label for="class">class: </label>
                    <select name="class">
                    <?php if(!empty($classes)) {
                        foreach ($classes as $class){
                            echo "<option value='{$class->getId()}'>{$class->getName()}</option>";
                        }
                    }
                    ?>
                    </select>
                </div>
                <button name="createStudent" type="submit">Submit</button>
            </form>
        </section>
        <?php endif ?>


    </div>
</section>



<?php require 'includes/footer.php'?>
