<?php
declare(strict_types=1);

namespace module\api\mapper\School;

use module\api\entity\School\RoleEntity;
use sf\phpmvc\mapper\AbstractMapper;

class RoleMapper extends AbstractMapper
{
    /**
     * @return RoleEntity
     */
    public function getRoleAdmin(): RoleEntity
    {
        return $this->findOneBy(['type' => RoleEntity::TYPE_ADMIN]);
    }
}