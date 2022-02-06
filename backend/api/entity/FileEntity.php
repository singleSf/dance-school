<?php
declare(strict_types=1);

namespace api\entity;

use sf\phpmvc\entity\AbstractEntity;
use sf\phpmvc\entity\TitleTraitEntity;

class FileEntity extends AbstractEntity
{
    use TitleTraitEntity;

    /** @var string */
    protected $extension;

    /** @var int */
    protected $size;

    /**
     * @return int
     */
    public function getSize(): int
    {
        return (int)$this->size;
    }

    /**
     * @param int $_size
     */
    public function setSize(int $_size): void
    {
        $this->size = $_size;
    }

    /**
     * todo SF
     *
     * @return string
     */
    public function getUri(): string
    {
        return '/user-file/'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $_extension
     */
    public function setExtension(string $_extension): void
    {
        $this->extension = $_extension;
    }

    /**
     * todo SF
     *
     * @return string
     */
    public function getPath(): string
    {
        return ROOT_PATH.'/data/user-file/'.$this->getId().'.'.$this->getExtension();
    }
}