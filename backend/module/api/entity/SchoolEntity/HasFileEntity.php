<?php
declare(strict_types=1);

namespace module\api\entity\SchoolEntity;

use module\api\entity\FileTraitEntity;
use module\api\entity\SchoolTraitEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TypeTraitEntity;

class HasFileEntity extends AbstractEntity
{
    use SchoolTraitEntity;
    use TypeTraitEntity;
    use FileTraitEntity;
    public const TYPE_LOGO         = 1;
    public const TYPE_SUBSCRIPTION = 2;

    /**
     * @return bool
     */
    public function isLogo(): bool
    {
        return $this->getType() === self::TYPE_LOGO;
    }

    /**
     * @return bool
     */
    public function isSubscription(): bool
    {
        return $this->getType() === self::TYPE_SUBSCRIPTION;
    }
}