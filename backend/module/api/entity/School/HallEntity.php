<?php
declare(strict_types=1);

namespace module\api\entity\School;

use module\api\entity\SchoolTraitEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class HallEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use SchoolTraitEntity;

    /** @var string */
    protected $address;

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $_address
     */
    public function setAddress(string $_address): void
    {
        $this->address = $_address;
    }
}