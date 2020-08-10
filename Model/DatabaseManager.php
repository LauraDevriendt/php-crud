<?php
class TeacherException extends Exception{}
class ClassException extends Exception{}
class StudentException extends Exception{}

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

    public function loadTeacher(int $id):Teacher{

            $q = $this->getDbcontroller()->prepare('select * from teacher where teacher_id = :id');
            $q->bindValue(':id', $id);
            $q->execute();
            $row = $q->fetch();
            return new Teacher($row['teacher_id'], $row['name'], $row['email']);


    }

    public function editTeacher(int $id, string $name, string $email){
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
        $handle = $this->getDbcontroller()->prepare('SELECT * FROM class');
        $handle->execute();
        $classes = $handle->fetchAll();
        foreach ($classes as $class) {
            $this->classes[] = new ClassBecode((int)$class['class_id'], $class['name'], $class['campus'], $class['teacher_id']);
        }
    }

    public function loadClass(int $id):ClassBecode{

        $q = $this->getDbcontroller()->prepare('select * from class where class_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $row = $q->fetch();
        return new ClassBecode($row['class_id'], $row['name'], $row['campus'],$row['teacher_id']);


    }
    public function editClass(int $id, string $name, string $campus, int $teacherId){
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
        $handle = $this->getDbcontroller()->prepare('SELECT * FROM student');
        $handle->execute();
        $students = $handle->fetchAll();
        foreach ($students as $student) {
            $this->students[] = new Student((int)$student['student_id'], $student['name'], $student['email'], $student['class_id']);
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


    public function loadStudent(int $id):Student{

        $q = $this->getDbcontroller()->prepare('select * from student where student_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $row = $q->fetch();
        return new Student($row['student_id'], $row['name'], $row['email'],$row['class_id']);


    }
    public function editStudent(int $id, string $name, string $email, int $classId){
        $q = $this->getDbcontroller()->prepare('UPDATE student SET name = :name, email = :email, class_id=:class_id WHERE student_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('email', $email);
        $q->bindValue('class_id', $classId);
        $q->execute();
    }

    public function createStudentTeacherList(int $teacher_id):string{
       $list="";

        $q = $this->getDbcontroller()->prepare(' SELECT student.student_id, student.name from student LEFT JOIN class ON student.class_id =class.class_id 
left join teacher ON class.teacher_id =teacher.teacher_id where teacher.teacher_id =:id ;');
        $q->bindValue(':id', $teacher_id);
        $q->execute();
        $rows=$q->fetchAll();
        foreach ($rows as $key=>$row){
            $key+=1;
          $list.="<button class='mb-1  btn-secondary'  value='{$row['student_id']}'>$key: {$row['name']}</button><br>";
       }
        return "<ol>".$list."</ol>";

    }
    public function createStudentClassList(int $class_id):string{
        $list="";
        $q = $this->getDbcontroller()->prepare(' SELECT student.student_id, student.name from student LEFT JOIN class ON student.class_id =class.class_id where class.class_id =:id ;');
        $q->bindValue(':id', $class_id);
        $q->execute();
        $rows=$q->fetchAll();
        foreach ($rows as $key=>$row){
            $key+=1;
            $list.="<button class='mb-1  btn-secondary'  value='{$row['student_id']}'>$key: {$row['name']}</button><br>";
        }
        return "<ol>".$list."</ol>";

    }



}