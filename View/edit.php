<?php require'View/includes/header.php'?>
<?php if (!empty($teacherEdit)) { ?>
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
 <?php if (!empty($editClass)) : ?>
        <section class="col-12 container my-2">
            <h5>Edit Class</h5>
            <form method="post">
                <input type='hidden' name='classId' value='<?php echo "{$editClass->getId()}"; ?>'>
                <div class="form-group">
                    <label for="className">Name:</label>
                    <input name="className" type="text" class="form-control" id="className" placeholder="Type here ..."
                           value='<?php echo "{$editClass->getName()}" ?>' required>
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
                        /**
                         * @var Teacher[] $teachers
                         */
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
<?php if (!empty($studentEdit)) : ?>
    <section class="col-12 container my-2">
        <h5>Edit a Student</h5>
        <form method="post">
            <div class="form-group">
                <input type='hidden' name='studentId' value='<?php echo "{$studentEdit->getId()}"; ?>'>
                <label for="studentName">Name:</label>
                <input name="studentName" type="text" class="form-control" id="studentName"
                       placeholder="Type here ..." value='<?php echo "{$studentEdit->getName()}"; ?>' required>
            </div>
            <div class="form-group">
                <label for="studentEmail">Email: </label>
                <input name="studentEmail" type="email" class="form-control" id="studentEmail"
                       placeholder="Type here ..." required value='<?php echo "{$studentEdit->getEmail()}"; ?>'>
            </div>
            <div class="form-group">
                <label for="class">class: </label>
                <select name="classId">
                    <?php if (!empty($classes)) {
                        foreach ($classes as $class) {
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
<?php require'View/includes/footer.php'?>
