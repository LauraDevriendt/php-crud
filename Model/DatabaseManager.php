<?php

class TeacherException extends Exception
{
}

class ClassException extends Exception
{
}

class StudentException extends Exception
{
}

class TeacherDeleteException extends Exception
{
}

class ClassDeleteException extends Exception
{
}

class DatabaseManager
{
    private PDO $dbcontroller;
    /**
     * @var Teacher[];
     */
    private $teachers = [];
    /**
     * @var ClassBecode[];
     */
    private $classes = [];
    /**
     * @var Student[];
     */
    private $students = [];
    private string $error = "";

    public function __construct()
    {
        // No bugs in this function, just use the right credentials.
        $dbhost = "localhost";
        $dbuser = "becode";
        $dbpass = PASS;
        $db = "crud";

        $driverOptions = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->dbcontroller = new PDO('mysql:host=' . $dbhost . ';dbname=' . $db, $dbuser, $dbpass, $driverOptions);
        $this->fetchTeachers();
        $this->fetchClasses();
        $this->fetchStudents();

    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }
    public function getTeachers(): ?array
    {
        $this->fetchTeachers();
        return $this->teachers;
    }
    public function getClasses(): ?array
    {
        $this->fetchClasses();
        return $this->classes;
    }
    public function getStudents(): ?array
    {
        $this->fetchStudents();
        return $this->students;
    }
    public function getError(): ?string
    {
        return $this->error;
    }

    public function getDbcontroller(): PDO
    {
        return $this->dbcontroller;
    }
    public function createTeacher(string $name, string $email)
    {
        $this->error = "";
        foreach ($this->getTeachers() as $teacher) {
            if (strtolower($teacher->getName()) === strtolower($name)) {
                $this->error = "Teacher already exists with that name";

            }
        }
        if (empty($this->error)) {
            $handle = $this->getDbcontroller()->prepare('INSERT INTO teacher (name,email) VALUES(:name,:email)');
            $handle->bindValue(':name', $name);
            $handle->bindValue(':email', $email);
            $handle->execute();
        }

    }
    public function fetchTeachers()
    {
        $this->teachers = [];
        $handle = $this->getDbcontroller()->prepare('SELECT * FROM teacher');
        $handle->execute();
        $teachers = $handle->fetchAll();
        foreach ($teachers as $teacher) {
            $this->teachers[] = new Teacher((int)$teacher['teacher_id'], $teacher['name'], $teacher['email']);
        }

    }
    public function loadTeacher(int $id): Teacher
    {

        $q = $this->getDbcontroller()->prepare('select * from teacher where teacher_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $row = $q->fetch();
        return new Teacher($row['teacher_id'], $row['name'], $row['email']);


    }
    public function editTeacher(int $id, string $name, string $email)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE teacher SET name = :name, email = :email WHERE teacher_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('email', $email);
        $q->execute();
    }
    public function createClass(string $name, string $campus, int $teacherId)
    {

        $this->error = "";
        foreach ($this->getClasses() as $class) {
            if (strtolower($class->getName()) === strtolower($name)) {
                $this->error = "Class already exists";

            }
        }
        if (empty($this->error)) {
            $handle = $this->getDbcontroller()->prepare('INSERT INTO class (name,campus,teacher_id) VALUES(:name,:campus,:teacher_id)');
            $handle->bindValue(':name', $name);
            $handle->bindValue(':campus', $campus);
            $handle->bindValue(':teacher_id', $teacherId);
            $handle->execute();
        }


    }
    public function fetchClasses()
    {
        $this->classes = [];
        $handle = $this->getDbcontroller()->prepare('SELECT class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,email FROM class JOIN teacher ON class.teacher_id=teacher.teacher_id');
        $handle->execute();
        $classes = $handle->fetchAll();
        foreach ($classes as $class) {
            $this->classes[] = new ClassBecode((int)$class['class_id'], $class['className'], $class['campus'],
                new Teacher ((int)$class['teacher_id'], $class['teacherName'], $class['email']));

        }
    }
    public function loadClass(int $id): ClassBecode
    {

        $q = $this->getDbcontroller()->prepare('SELECT class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,email FROM class JOIN teacher on class.teacher_id=teacher.teacher_id where class_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $class = $q->fetch();
        return new ClassBecode((int)$class['class_id'], $class['className'], $class['campus'],
            new Teacher ((int)$class['teacher_id'], $class['teacherName'], $class['email']));


    }
    public function editClass(int $id, string $name, string $campus, int $teacherId)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE class SET name = :name, campus = :campus, teacher_id=:teacher_id WHERE class_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('campus', $campus);
        $q->bindValue('teacher_id', $teacherId);
        $q->execute();
    }
    public function fetchStudents()
    {
        $this->students = [];
        $handle = $this->getDbcontroller()->prepare('SELECT student_id, student.name as studentName, student.email as studentEmail, class.class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,teacher.email FROM student JOIN class ON student.class_id=class.class_id JOIN teacher ON teacher.teacher_id=class.teacher_id');
        $handle->execute();
        $students = $handle->fetchAll();
        foreach ($students as $student) {
            $this->students[] = new Student((int)$student['student_id'], $student['studentName'], $student['studentEmail'],
                new ClassBecode((int)$student['class_id'], $student['className'], $student['campus'],
                    new Teacher ((int)$student['teacher_id'], $student['teacherName'], $student['email'])));
        }
    }
    public function createStudent(string $name, string $email, int $classId)
    {

        $this->error = "";
        foreach ($this->getStudents() as $student) {
            if (strtolower($student->getName()) === strtolower($name)) {
                $this->error = "Student already exists with that name";

            }
        }
        if (empty($this->error)) {
            $handle = $this->getDbcontroller()->prepare('INSERT INTO student (name,email,class_id) VALUES(:name,:email,:class_id)');
            $handle->bindValue(':name', $name);
            $handle->bindValue(':email', $email);
            $handle->bindValue(':class_id', $classId);
            $handle->execute();
        }
    }
    public function loadStudent(int $id): Student
    {

        $q = $this->getDbcontroller()->prepare('SELECT student_id, student.name as studentName, student.email as studentEmail, class.class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,teacher.email FROM student JOIN class ON student.class_id=class.class_id JOIN teacher ON teacher.teacher_id=class.teacher_id where student.student_id=:id');
        $q->bindValue(':id', $id);
        $q->execute();
        $student = $q->fetch();
        return new Student((int)$student['student_id'], $student['studentName'], $student['studentEmail'],
            new ClassBecode((int)$student['class_id'], $student['className'], $student['campus'],
                new Teacher ((int)$student['teacher_id'], $student['teacherName'], $student['email'])));


    }
    public function editStudent(int $id, string $name, string $email, ?int $classId)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE student SET name = :name, email = :email, class_id=:class_id WHERE student_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('email', $email);
        $q->bindValue('class_id', $classId);
        $q->execute();
    }
    public function createStudentTeacherList(int $teacher_id): string
    {
        $list = "";

        $q = $this->getDbcontroller()->prepare(' SELECT student.student_id, student.name from student LEFT JOIN class ON student.class_id =class.class_id 
left join teacher ON class.teacher_id =teacher.teacher_id where teacher.teacher_id =:id ;');
        $q->bindValue(':id', $teacher_id);
        $q->execute();
        $rows = $q->fetchAll();
        foreach ($rows as $key => $row) {
            $key += 1;
            $list .= "<a href='?details=student&id={$row['student_id']}' class='mb-1 '>$key: {$row['name']}</a><br>";
        }
        return "<ol>" . $list . "</ol>";

    }
    public function createStudentClassList(int $class_id): string
    {
        $list = "";
        $q = $this->getDbcontroller()->prepare(' SELECT student.student_id, student.name from student LEFT JOIN class ON student.class_id =class.class_id where class.class_id =:id ;');
        $q->bindValue(':id', $class_id);
        $q->execute();
        $rows = $q->fetchAll();
        foreach ($rows as $key => $row) {
            $key += 1;
            $list .= "<a href='?details=student&id={$row['student_id']}' class='mb-1 '>$key: {$row['name']}</a><br>";
        }
        return "<ol>" . $list . "</ol>";

    }
    public function findTeacherById(int $id): ?Teacher
    {
        foreach ($this->teachers as $teacher) {
            if ($teacher->getId() == $id) {
                return $teacher;
            }
        }
    }
    public function findClassById(int $id): ?ClassBecode
    {
        foreach ($this->classes as $class) {
            if ($class->getId() == $id) {
                return $class;
            }
        }
    }
    public function findStudentById(int $id): ?Student
    {
        foreach ($this->students as $student) {
            if ($student->getId() === $id) {
                return $student;
            }
        }
    }
    public function deleteTeacher(Teacher $teacher)
    {
        foreach ($this->classes as $class) {
            if ($class->getTeacher()->getId() === $teacher->getId()) {
                throw new TeacherDeleteException("This teacher is still assigned to the class <strong>{$class->getName()}</strong>. Assign to other class first");
            }
        }
        $handle = $this->getDbcontroller()->prepare('DELETE FROM teacher WHERE teacher_id = :id');
        $handle->bindValue(':id', ($teacher->getId()));
        $handle->execute();

    }
    public function deleteClass(ClassBecode $class)
    {
        foreach ($this->students as $student) {
            if ($student->getClass()->getId() === $class->getId()) {
                throw new ClassDeleteException("The student <strong>{$student->getName()}</strong> is still assigned to the class <strong>{$class->getName()}</strong>. Assign to other class first");
            }
        }

        $handle = $this->getDbcontroller()->prepare('DELETE FROM class WHERE class_id = :id');
        $handle->bindValue(':id', ($class->getId()));
        $handle->execute();


    }
    public function deleteStudent(Student $student)
    {

        $handle = $this->getDbcontroller()->prepare('DELETE FROM student WHERE student_id = :id');
        $handle->bindValue(':id', ($student->getId()));
        $handle->execute();


    }


}