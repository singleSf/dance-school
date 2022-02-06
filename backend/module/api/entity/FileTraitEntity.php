<?php
declare(strict_types=1);

namespace module\api\entity;

trait FileTraitEntity
{
    /** @var int */
    protected $file_id;

    /** @var FileEntity */
    private $file;

    /**
     * @return int
     */
    public function getFileId(): int
    {
        return (int)$this->file_id;
    }

    /**
     * @param int $_file_id
     */
    public function setFileId(int $_file_id): void
    {
        $this->file_id = $_file_id;
    }

    /**
     * @return FileEntity
     */
    public function getFile(): FileEntity
    {
        return $this->file;
    }

    /**
     * @param FileEntity $_file
     */
    public function setFile(FileEntity $_file): void
    {
        $this->file = $_file;

        $this->setFileId($_file->getId());
    }
}