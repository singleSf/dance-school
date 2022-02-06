<?php
declare(strict_types=1);

namespace api\mapper;

use api\entity\FileEntity;
use sf\phpmvc\mapper\AbstractMapper;

class FileMapper extends AbstractMapper
{
    /**
     * @param FileEntity $_file
     */
    public function saveFile(FileEntity $_file): void
    {
        $this->saveEntity($_file);
    }

    /**
     * @param FileEntity $_file
     */
    public function deleteFile(FileEntity $_file): void
    {
        if (unlink($_file->getPath())) {
            $this->deleteEntity($_file);
        }
    }
}