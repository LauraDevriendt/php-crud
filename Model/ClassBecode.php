<?php


class ClassBecode
{
private int $id;
private string $name;
private string $campus;
private Teacher $teacher;


    public function __construct(int $id, string $name, string $campus, Teacher $teacher)
    {
        $this->id = $id;
        $this->name = $name;
        $this->campus = $campus;
        $this->teacher= $teacher;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCampus(): string
    {
        return $this->campus;
    }

    /**
     * @return int
     */
    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }
}