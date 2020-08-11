<?php
class StudentException extends Exception
{
}
class StudentCreateException extends Exception
{
}

class StudentLoader extends DatabaseManager
{
    public function create(string $name, string $email, int $classId)
    {

        $this->error = "";
        foreach ($this->getStudents() as $student) {
            if (strtolower($student->getName()) === strtolower($name)) {
               throw new StudentCreateException("Student already exists with that name");

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
    public function load(int $id): Student
    {

        $q = $this->getDbcontroller()->prepare('SELECT student_id, student.name as studentName, student.email as studentEmail, class.class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,teacher.email FROM student JOIN class ON student.class_id=class.class_id JOIN teacher ON teacher.teacher_id=class.teacher_id where student.student_id=:id');
        $q->bindValue(':id', $id);
        $q->execute();
        $student = $q->fetch();
        return new Student((int)$student['student_id'], $student['studentName'], $student['studentEmail'],
            new ClassBecode((int)$student['class_id'], $student['className'], $student['campus'],
                new Teacher ((int)$student['teacher_id'], $student['teacherName'], $student['email'])));


    }
    public function edit(int $id, string $name, string $email, ?int $classId)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE student SET name = :name, email = :email, class_id=:class_id WHERE student_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('email', $email);
        $q->bindValue('class_id', $classId);
        $q->execute();
    }
    public function delete(Student $student)
    {

        $handle = $this->getDbcontroller()->prepare('DELETE FROM student WHERE student_id = :id');
        $handle->bindValue(':id', ($student->getId()));
        $handle->execute();


    }
    public function findById(int $id): ?Student
    {
        foreach ($this->students as $student) {
            if ($student->getId() === $id) {
                return $student;
            }
        }
    }
}