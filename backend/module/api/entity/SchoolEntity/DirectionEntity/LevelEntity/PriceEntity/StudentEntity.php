<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity\DirectionEntity\LevelEntity\PriceEntity;

use DateTime;
use Exception;
use RuntimeException;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\UserTraitEntity;
use sf\phpmvc\mapper\AbstractMapper;

class StudentEntity extends AbstractEntity
{
    use UserTraitEntity;

    /** @var int */
    protected $school_direction_level_price_id;

    /** @var DateTime */
    protected $date_start;

    /** @var int */
    protected $price;

    /**
     * @return int
     */
    public function getSchoolDirectionLevelPriceId(): int
    {
        return (int)$this->school_direction_level_price_id;
    }

    /**
     * @param int $_school_direction_level_price_id
     */
    public function setSchoolDirectionLevelPriceId(int $_school_direction_level_price_id): void
    {
        $this->school_direction_level_price_id = $_school_direction_level_price_id;
    }

    /**
     * @return DateTime
     */
    public function getDateStart(): DateTime
    {
        $date = null;
        try {
            $date = new DateTime($this->date_start);
        } catch (Exception $exception) {
            throw new RuntimeException('Невозможно создать дату');
        }

        return $date;
    }

    /**
     * @param DateTime $_dateStart
     */
    public function setDateStart(DateTime $_dateStart): void
    {
        $this->date_start = $_dateStart->format(AbstractMapper::DATE_FORMAT);
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
}