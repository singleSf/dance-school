<?php
declare(strict_types=1);

namespace api\mapper\SchoolMapper;

use api\entity\FileEntity;
use api\entity\SchoolEntity;
use api\helper\AbstractToolHelper;
use sf\phpmvc\mapper\AbstractMapper;

class HasFileMapper extends AbstractMapper
{
    /**
     * @param SchoolEntity[] $_schools
     */
    public function setupFiles(array $_schools): void
    {
        if (empty($_schools)) {
            return;
        }
        /** @var SchoolEntity\HasFileEntity[] $hases */
        $hases = $this->fetchAll(['school_id' => array_keys($_schools)]);

        if (empty($hases)) {
            return;
        }

        $fileIds = [];
        foreach ($hases as $has) {
            $fileIds[$has->getFileId()] = $has->getFileId();
        }

        $fileMapper = AbstractToolHelper::getFileMapper();
        /** @var FileEntity[] $files */
        $files = $fileMapper->fetchAll(['id' => $fileIds]);

        foreach ($hases as $has) {
            $file = $files[$has->getFileId()];
            $has->setFile($file);

            $school = $_schools[$has->getSchoolId()];

            $school->addFile($has);
        }
    }

    /**
     * @param SchoolEntity\HasFileEntity $_has
     */
    public function saveHas(SchoolEntity\HasFileEntity $_has): void
    {
        $this->saveEntity($_has);
    }
}