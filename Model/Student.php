<?php


class Student
{
private int $id;
private string $name;
private string $email;
private ClassBecode $class;

    public function __construct(int $id, string $name, string $email, ?ClassBecode $class)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->class = $class;
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


    public function getClass(): ClassBecode
    {
        return $this->class;
    }
}