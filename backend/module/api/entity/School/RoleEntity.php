<?php
declare(strict_types=1);

namespace module\api\entity\School;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\ParentIdTraitEntity;
use sf\phpmvc\entity\TitleTraitEntity;
use sf\phpmvc\entity\TypeTraitEntity;

class RoleEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use ParentIdTraitEntity;
    use TypeTraitEntity;
    public const TYPE_STUDENT = 1;
    public const TYPE_TEACHER = 2;
    public const TYPE_ADMIN   = 3;
}