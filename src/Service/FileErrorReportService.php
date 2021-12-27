<?php

namespace App\Service;

use App\Entity\FileErrorReporting;
use App\Entity\UploadedFiles;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class FileErrorReportService
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create($data)
    {
        $fileErrorReport = new FileErrorReporting();
        $fileErrorReport->setFile($data['file']);
        $fileErrorReport->setErrorDetail($data['error_detail']);
        $fileErrorReport->setErrorRowId($data['error_row_id']);
        $fileErrorReport->setErrorRowString($data['error_row_string']);

        $this->em->persist($fileErrorReport);
        $this->em->flush();
    }
}