<?php
declare(strict_types=1);

namespace module\api\mapper\SchoolMapper;

use module\api\entity\SchoolEntity\RoleEntity;
use sf\phpmvc\mapper\AbstractMapper;
use sf\phpmvc\mapper\where\Where;

class RoleMapper extends AbstractMapper
{
    /**
     * @param int $_type
     *
     * @return RoleEntity
     */
    public function getRoleByType(int $_type): RoleEntity
    {
        $where = new Where();
        $where->equalTo('type', $_type);

        return $this->findOneBy($where);
    }
}