<?php
class TeacherException extends Exception
{
}
class TeacherCreateException extends Exception{}
class TeacherDeleteException extends Exception
{
}
class TeacherLoader extends DatabaseManager
{

    public function create(string $name, string $email)
    {


        foreach ($this->getTeachers() as $teacher) {
            if (strtolower($teacher->getName()) === strtolower($name)) {
                throw new TeacherCreateException( "Teacher already exists with that name");

            }
        }
        if (empty($this->error)) {
            $handle = $this->getDbcontroller()->prepare('INSERT INTO teacher (name,email) VALUES(:name,:email)');
            $handle->bindValue(':name', $name);
            $handle->bindValue(':email', $email);
            $handle->execute();

        }

    }
    public function load(int $id): Teacher
    {

        $q = $this->getDbcontroller()->prepare('select * from teacher where teacher_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $row = $q->fetch();
        return new Teacher($row['teacher_id'], $row['name'], $row['email']);


    }
    public function edit(int $id, string $name, string $email)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE teacher SET name = :name, email = :email WHERE teacher_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('email', $email);
        $q->execute();
    }
    public function delete(?Teacher $teacher)
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
    public function findById(int $id): Teacher
    {
        foreach ($this->teachers as $teacher) {
            if ($teacher->getId() == $id) {
                return $teacher;
            }
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
}