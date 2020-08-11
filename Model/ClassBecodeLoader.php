<?php


class ClassException extends Exception
{
}

class ClassDeleteException extends Exception
{
}

class ClassCreateException extends Exception
{
}

class classBecodeLoader extends DatabaseManager
{
    public function create(string $name, string $campus, int $teacherId)
    {

        $this->error = "";
        foreach ($this->getClasses() as $class) {
            if (strtolower($class->getName()) === strtolower($name)) {
               throw  new ClassCreateException("Class already exists");

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

    public function load(int $id): ClassBecode
    {

        $q = $this->getDbcontroller()->prepare('SELECT class_id, class.name as className, campus, class.teacher_id, teacher.name as teacherName,email FROM class JOIN teacher on class.teacher_id=teacher.teacher_id where class_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $class = $q->fetch();
        return new ClassBecode((int)$class['class_id'], $class['className'], $class['campus'],
            new Teacher ((int)$class['teacher_id'], $class['teacherName'], $class['email']));


    }

    public function edit(int $id, string $name, string $campus, int $teacherId)
    {
        $q = $this->getDbcontroller()->prepare('UPDATE class SET name = :name, campus = :campus, teacher_id=:teacher_id WHERE class_id = :id');
        $q->bindValue('id', $id);
        $q->bindValue('name', $name);
        $q->bindValue('campus', $campus);
        $q->bindValue('teacher_id', $teacherId);
        $q->execute();
    }

    public function delete(ClassBecode $class)
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

    public function findById(int $id): ?ClassBecode
    {
        foreach ($this->classes as $class) {
            if ($class->getId() == $id) {
                return $class;
            }
        }
    }
}