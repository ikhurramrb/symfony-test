<?php

namespace App\Service;

use App\Entity\UploadedFiles;
use App\Repository\UploadedFilesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;

class UploadedFileService
{
    protected $em;
    protected $uploadedFilesRepository;

    public function __construct(EntityManagerInterface $em, UploadedFilesRepository $uploadedFilesRepository)
    {
        $this->em = $em;
        $this->uploadedFilesRepository = $uploadedFilesRepository;
    }

    /**
     * @param $data
     * @return UploadedFiles
     */
    public function create($data): UploadedFiles
    {
        $uploadedFile = new UploadedFiles();
        $uploadedFile->setName($data['fileName']);
        $uploadedFile->setCreatedAt($data['created_at']);
        $this->em->persist($uploadedFile);
        $this->em->flush();
        return $uploadedFile;
    }

    /**
     * @return UploadedFiles[]
     */
    public function getAll(): array
    {
        return $this->uploadedFilesRepository->findBy([], ['created_at' => 'DESC']);
    }

    /**
     * @param $id
     * @return array
     */
    public function getDetail($id)
    {
        $file = $this->uploadedFilesRepository->find($id);

        return [
            'uploaded_invoices' => $file->getInvoices(),
            'error_rows' => $file->getErrorRows()
        ];

    }
}