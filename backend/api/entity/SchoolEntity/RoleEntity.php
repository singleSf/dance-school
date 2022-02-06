<?php
declare(strict_types=1);

namespace api\entity\SchoolEntity;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\ParentIdTraitEntity;
use sf\phpmvc\entity\TitleTraitEntity;
use sf\phpmvc\entity\TypeTraitEntity;

class RoleEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use ParentIdTraitEntity;
    use TypeTraitEntity;
    public const TYPE_PARTICIPANT = 1;
    public const TYPE_TEACHER     = 2;
    public const TYPE_ADMIN       = 3;
    public const TYPES            = [
        self::TYPE_PARTICIPANT,
        self::TYPE_TEACHER,
        self::TYPE_ADMIN,
    ];
}