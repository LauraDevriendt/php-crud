<?php


class Student
{
private int $id;
private string $name;
private string $email;
private int $classId;

    public function __construct(int $id, string $name, string $email, int $classId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->classId = $classId;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function getClassId(): int
    {
        return $this->classId;
    }
}