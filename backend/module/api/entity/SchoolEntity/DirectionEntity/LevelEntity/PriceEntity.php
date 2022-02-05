<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity\LevelEntity;

use module\api\entity\SchoolEntity\DirectionEntity\LevelEntity\PriceEntity\StudentEntity;
use sf\phpmvc\entity\AbstractEntity;

class PriceEntity extends AbstractEntity
{
    /** @var int */
    protected $school_direction_level_id;

    /** @var int */
    protected $count_lesson;

    /** @var int */
    protected $count_skip;

    /** @var int */
    protected $price;

    /** @var StudentEntity[] */
    private $students = [];

    /**
     * @return int
     */
    public function getSchoolDirectionLevelId(): int
    {
        return (int)$this->school_direction_level_id;
    }

    /**
     * @param int $_school_direction_level_id
     */
    public function setSchoolDirectionLevelId(int $_school_direction_level_id): void
    {
        $this->school_direction_level_id = $_school_direction_level_id;
    }

    /**
     * @return int
     */
    public function getCountLesson(): int
    {
        return (int)$this->count_lesson;
    }

    /**
     * @param int $_count_lesson
     */
    public function setCountLesson(int $_count_lesson): void
    {
        $this->count_lesson = $_count_lesson;
    }

    /**
     * @return int
     */
    public function getCountSkip(): int
    {
        return (int)$this->count_skip;
    }

    /**
     * @param int $_count_skip
     */
    public function setCountSkip(int $_count_skip): void
    {
        $this->count_skip = $_count_skip;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return (int)$this->price;
    }

    /**
     * @param int $_price
     */
    public function setPrice(int $_price): void
    {
        $this->price = $_price;
    }

    /**
     * @return StudentEntity[]
     */
    public function getStudents(): array
    {
        return $this->students;
    }

    /**
     * @param StudentEntity[] $_students
     */
    public function setStudents(array $_students): void
    {
        $this->students = $_students;
    }

    /**
     * @param StudentEntity $_student
     */
    public function addStudent(StudentEntity $_student): void
    {
        $this->students[$_student->getId()] = $_student;
    }
}