<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper\DirectionMapper\SubscriptionMapper;

use module\api\entity\SchoolEntity\DirectionEntity;
use module\api\mapper\SchoolMapper\RoleMapper\UserTraitMapper;
use sf\phpmvc\mapper\AbstractMapper;

class HasUserMapper extends AbstractMapper
{
    use UserTraitMapper;
}