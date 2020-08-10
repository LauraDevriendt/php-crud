<?php


class ClassBecode
{
private int $id;
private string $name;
private string $campus;
private int $teacherId;


    public function __construct(int $id, string $name, string $campus, int $teacherId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->campus = $campus;
        $this->teacherId = $teacherId;
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
    public function getTeacherId(): int
    {
        return $this->teacherId;
    }
}