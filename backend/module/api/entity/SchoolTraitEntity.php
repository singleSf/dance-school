<?php
declare(strict_types=1);

namespace module\api\entity;

trait SchoolTraitEntity
{
    /** @var int */
    protected $school_id;

    /** @var SchoolEntity */
    private $school;

    /**
     * @return SchoolEntity
     */
    public function getSchool(): SchoolEntity
    {
        return $this->school;
    }

    /**
     * @param SchoolEntity $_school
     */
    public function setSchool(SchoolEntity $_school): void
    {
        $this->school = $_school;
    }

    /**
     * @return int
     */
    public function getSchoolId(): int
    {
        return (int)$this->school_id;
    }

    /**
     * @param int $_school_id
     */
    public function setSchoolId(int $_school_id): void
    {
        $this->school_id = $_school_id;
    }
}