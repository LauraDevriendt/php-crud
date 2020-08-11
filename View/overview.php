<?php require 'includes/header.php' ?>
<section class="container">
    <?php if(empty($teacherEdit) && empty($editClass) && empty($studentEdit)):?>
    <h1>Overview</h1>
    <h2>Teachers</h2>
    <form method='post' action=''>
        <button  class='mb-1 btn btn-success' type='submit' name='creationTeacher'>New Teacher</button>
        <button  class='mb-1 btn btn-info' type='submit' name='detailedOverviewTeacher'>More Detail</button>

    </form>
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
            <td>{$teacher->getName()}</td>
            <td>
            <form method='post' action=''>
            <button  class='btn btn-danger' type='submit' name='deleteTeacher'>Delete</button>
            <button class='btn btn-info' type='submit' name='editTeacher'>Edit</button>
            <input type='hidden' name='teacherId' value='{$teacher->getId()}'>
            </form>
            </td>
        </tr>";
        }
        ?>
        </tbody>
    </table>
    <?php endif;?>
    <?php
    /**
     * @var Teacher $teacherEdit
     */
    if (!empty($teacherEdit)) { ?>
        <section class="edit">
            <h2>Edit Teacher</h2>
            <form method="post">
                <input type='hidden' name='teacherId' value='<?php echo "{$teacherEdit->getId()}" ?>'>
                <div class="form-group">
                    <label for="teacherName">Name:</label>
                    <input name="teacherName" type="text" class="form-control" id="teacherName"
                           placeholder="Type here ..." value="<?php echo "{$teacherEdit->getName()}" ?>" required>
                </div>
                <div class="form-group">
                    <label for="teacherEmail">Email: </label>
                    <input name="teacherEmail" type="teacherEmail" class="form-control" id="teacherEmail"
                           placeholder="Type here ..." value="<?php echo "{$teacherEdit->getEmail()}" ?>" required>
                </div>
                <button name="editingTeacher" type="submit">Submit</button>
            </form>
        </section>
    <?php } ?>
    <?php if(empty($teacherEdit) && empty($editClass) && empty($studentEdit)):?>
    <h2>Classes</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-success' type='submit' name='creationClass'>New Class</button>
            <button  class='mb-1 btn btn-info' type='submit' name='detailedOverviewClass'>More detail</button>
        </form>
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
            <td>{$class->getName()}</td>
            <td><form method='post'>
                        <input type='hidden' name='classId' value='{$class->getId()}'>
            <button  class='btn btn-danger' type='submit' name='deleteClass'>Delete</button>
            <button class='btn btn-info' type='submit' name='editClass'>Edit</button>
</form></td>
        </tr>";
        }
        ?>
        </tbody>
    </table>
    <?php endif;?>
    <?php if (!empty($editClass)) : ?>
        <section class="col-12 container my-2">
            <h5>Edit Class</h5>
            <form method="post">
                <input type='hidden' name='classId' value='<?php echo "{$editClass->getId()}";?>'>
                <div class="form-group">
                    <label for="className">Name:</label>
                    <input name="className" type="text" class="form-control" id="className" placeholder="Type here ..."
                           value='<?php echo "{$editClass->getName()}" ?>'  required>
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
                    <select name="teacherId" id="teacher">
                        <?php
                        foreach ($teachers as $teacher) {
                            echo "<option value='{$teacher->getId()}'>{$teacher->getName()}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button name="editingClass" type="submit">Submit</button>
            </form>
        </section>
    <?php endif ?>
    <?php if(empty($teacherEdit) && empty($editClass) && empty($studentEdit)):?>
    <h2>Students</h2>
        <form method='post' action=''>
            <button  class='mb-1 btn btn-success' type='submit' name='creationStudent'>New Student</button>
            <button  class='mb-1 btn btn-info' type='submit' name='detailedOverviewStudent'>More Detail</button>

        </form>
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
            <td>{$student->getName()}</td>
            <td><form method='post'>
            <input type='hidden' name='studentId' value='{$student->getId()}'>
            <button  class='btn btn-danger' type='submit' name='deleteStudent' >Delete</button>
            <button class='btn btn-info' type='submit' name='editStudent' >Edit</button>   
            
            
</form></td>
        </tr>";
        }
        ?>
        </tbody>
    </table>
    <?php endif;?>
    <?php if(!empty($studentEdit)) :?>
        <section class="col-12 container my-2">
            <h5>Edit a Student</h5>
            <form method="post">
                <div class="form-group">
                    <input type='hidden' name='studentId' value='<?php echo "{$studentEdit->getId()}";?>'>
                    <label for="studentName">Name:</label>
                    <input name="studentName" type="text" class="form-control" id="studentName" placeholder="Type here ..." value='<?php echo "{$studentEdit->getName()}";?>'required>
                </div>
                <div class="form-group">
                    <label for="studentEmail">Email: </label>
                    <input name="studentEmail" type="email" class="form-control" id="studentEmail" placeholder="Type here ..." required value='<?php echo "{$studentEdit->getEmail()}";?>'>
                </div>
                <div class="form-group">
                    <label for="class">class: </label>
                    <select name="classId">
                        <?php if(!empty($classes)) {
                            foreach ($classes as $class){
                                echo "<option value='{$class->getId()}'>{$class->getName()}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button name="editingStudent" type="submit">Submit</button>
            </form>
        </section>
    <?php endif ?>
</section>


<?php require 'includes/footer.php' ?>
