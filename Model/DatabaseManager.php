<?php




class DatabaseManager
{
    protected PDO $dbcontroller;
    /**
     * @var Teacher[];
     */
    protected $teachers = [];
    /**
     * @var ClassBecode[];
     */
    protected $classes = [];
    /**
     * @var Student[];
     */
    protected $students = [];
    protected string $error = "";
    protected string $message="";

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
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    public function getDbcontroller(): PDO
    {
        return $this->dbcontroller;
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
    public function getMessage(): ?string
    {
        return $this->message;
    }


    private function fetchTeachers()
    {
        $this->teachers = [];
        $handle = $this->getDbcontroller()->prepare('SELECT * FROM teacher');
        $handle->execute();
        $teachers = $handle->fetchAll();
        foreach ($teachers as $teacher) {
            $this->teachers[] = new Teacher((int)$teacher['teacher_id'], $teacher['name'], $teacher['email']);
        }

    }
    private function fetchClasses()
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
    private function fetchStudents()
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








}