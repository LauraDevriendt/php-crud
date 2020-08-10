<?php require 'includes/header.php' ?>
<section class="container">
    <h1>Overview</h1>
    <h2>Teachers</h2>
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
    <?php
    /**
     * @var Teacher $teacherEdit
     */
    if(!empty($teacherEdit)) { ?>
        <section class="edit">
            <form method="post">
                <input type='hidden' name='teacherId' value='<?php echo "{$teacherEdit->getId()}"?>'>
                <div class="form-group">
                    <label for="teacherName">Name:</label>
                    <input name="teacherName" type="text" class="form-control" id="teacherName" placeholder="Type here ..." value="<?php echo "{$teacherEdit->getName()}"?>" required>
                </div>
                <div class="form-group">
                    <label for="teacherEmail">Email: </label>
                    <input name="teacherEmail" type="teacherEmail" class="form-control" id="teacherEmail" placeholder="Type here ..." value="<?php echo "{$teacherEdit->getEmail()}"?>" required>
                </div>
                <button name="EditingTeacher" type="submit">Submit</button>
            </form>
        </section>
    <?php  }?>
    <h2>Classes</h2>
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
            <button  class='btn btn-danger' type='submit' name='deleteClass'>Delete</button>
            <button class='btn btn-info' type='submit' name='editClass'>Edit</button>
</form></td>
        </tr>";
        }
        ?>
        </tbody>
    </table>
    <h2>Students</h2>
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
            <button  class='btn btn-danger' type='submit' name='deleteStudent' >Delete</button>
            <button class='btn btn-info' type='submit' name='editStudent' >Edit</button>   
             <input type='hidden' name='id' value='$key'>
            
</form></td>
        </tr>";
        }
        ?>
        </tbody>
    </table>

</section>

<?php require 'includes/footer.php' ?>
