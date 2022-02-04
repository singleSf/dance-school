<?php
declare(strict_types=1);

namespace module\api\entity\School;

use module\api\entity\SchoolTraitEntity;
use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class DirectionEntity extends AbstractEntity
{
    use TitleTraitEntity;
    use SchoolTraitEntity;
}